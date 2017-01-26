<?php

namespace Sugarcrm\UpgradeSpec;

use Humbug\SelfUpdate\Strategy\GithubStrategy;
use Humbug\SelfUpdate\Updater as HumbugUpdater;
use League\HTMLToMarkdown\HtmlConverter;
use Sugarcrm\UpgradeSpec\Cache\Adapter\File as FileCache;
use Sugarcrm\UpgradeSpec\Cache\Cache;
use Sugarcrm\UpgradeSpec\Command\CacheClearCommand;
use Sugarcrm\UpgradeSpec\Command\GenerateSpecCommand;
use Sugarcrm\UpgradeSpec\Command\SelfRollbackCommand;
use Sugarcrm\UpgradeSpec\Command\SelfUpdateCommand;
use Sugarcrm\UpgradeSpec\Data\Manager;
use Sugarcrm\UpgradeSpec\Data\Provider\LocalUpgradePackage;
use Sugarcrm\UpgradeSpec\Data\Provider\SupportSugarcrm;
use Sugarcrm\UpgradeSpec\Data\ProviderChain;
use Sugarcrm\UpgradeSpec\Element\Generator as ElementGenerator;
use Sugarcrm\UpgradeSpec\Element\Provider;
use Sugarcrm\UpgradeSpec\Formatter\MarkdownFormatter;
use Sugarcrm\UpgradeSpec\Helper\File;
use Sugarcrm\UpgradeSpec\Helper\Sugarcrm;
use Sugarcrm\UpgradeSpec\Spec\Generator;
use Sugarcrm\UpgradeSpec\Template\TwigRenderer;
use Sugarcrm\UpgradeSpec\Updater\Adapter\HumbugAdapter;
use Sugarcrm\UpgradeSpec\Updater\Updater;
use Symfony\Component\Console\Application as BaseApplication;
use Symfony\Component\Dotenv\Dotenv;
use Twig_Loader_Filesystem;

final class Application extends BaseApplication
{
    /**
     * Application constructor.
     *
     * @param $name
     * @param $version
     */
    public function __construct($name, $version)
    {
        parent::__construct($name, $version);

        $this->initEnvironment();
        $this->initCommands();
    }

    /**
     * Gets full version name.
     *
     * @return string
     */
    public function getLongVersion()
    {
        return parent::getLongVersion() . ' by <comment>Mike Kamornikov</comment> and <comment>Denis Stiblo</comment>';
    }

    /*
     * Init application environment.
     */
    private function initEnvironment()
    {
        $env = new Dotenv();

        $envPath = __DIR__ . '/../.env';
        if (file_exists($envPath)) {
            $env->populate($env->parse(file_get_contents($envPath), $envPath));
        }

        $envPath = __DIR__ . '/../.env.dist';
        $env->populate($env->parse(file_get_contents($envPath), $envPath));
    }

    /**
     * Init commands.
     *
     * @return array
     */
    private function initCommands()
    {
        $commands = [];

        $cache = $this->getCache();
        $dataManager = new Manager(
            new ProviderChain([
                new SupportSugarcrm($cache, new HtmlConverter([
                    'strip_tags' => true,
                    'header_style' => 'atx',
                ])),
                new LocalUpgradePackage(),
            ])
        );
        $formatter = new MarkdownFormatter();
        $templateRenderer = new TwigRenderer(
            new Twig_Loader_Filesystem(__DIR__ . '/../' . getenv('TEMPLATE_PATH') . '/' . getenv('DEFAULT_FORMAT')),
            ['debug' => (bool) getenv('DEV_MODE')]
        );

        $specGenerator = new Generator(
            new Provider($templateRenderer, $dataManager),
            new ElementGenerator($formatter),
            $formatter
        );

        $generateSpecCommand = new GenerateSpecCommand(null, $specGenerator, $dataManager, new Sugarcrm(), new File());

        $commands[] = $generateSpecCommand;
        $commands[] = new CacheClearCommand(null, $cache);

        if ($this->isUpdateAvailable()) {
            $strategy = new GithubStrategy();
            $strategy->setPackageName(getenv('PACKAGE_NAME'));
            $strategy->setPharName(getenv('PHAR_BASENAME') . '.phar');
            $strategy->setCurrentLocalVersion($this->getVersion());

            $humbugUpdater = new HumbugUpdater();
            $humbugUpdater->setStrategyObject($strategy);

            $path = sys_get_temp_dir() . '/' . getenv('PHAR_BASENAME') . '-old.phar';
            $humbugUpdater->setBackupPath($path);
            $humbugUpdater->setRestorePath($path);

            $updater = new Updater(new HumbugAdapter($humbugUpdater));

            $commands[] = new SelfUpdateCommand(null, $updater);
            $commands[] = new SelfRollbackCommand(null, $updater);
        }

        $this->addCommands($commands);
    }

    /**
     * Defines if current execution context supports self updates.
     *
     * @return string
     */
    private function isUpdateAvailable()
    {
        return getenv('DEV_MODE') || \Phar::running();
    }

    /**
     * Cache factory method.
     *
     * @return Cache
     */
    private function getCache()
    {
        $cachePath = getenv('CACHE_PATH');
        if (!$cachePath) {
            $cachePath = sys_get_temp_dir() . '/.' . getenv('PHAR_BASENAME');
        }

        $cacheTtl = getenv('CACHE_TTL');
        if (!$cacheTtl) {
            $cacheTtl = 3600;
        }

        return new Cache(new FileCache($cachePath, $cacheTtl));
    }
}
