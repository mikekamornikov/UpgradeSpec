<?php

namespace Sugarcrm\UpgradeSpec;

use Humbug\SelfUpdate\Strategy\GithubStrategy;
use Humbug\SelfUpdate\Updater as HumbugUpdater;
use League\HTMLToMarkdown\HtmlConverter;
use Sugarcrm\UpgradeSpec\Cache\Cache;
use Sugarcrm\UpgradeSpec\Cache\Adapter\File as FileCache;
use Sugarcrm\UpgradeSpec\Command\CacheClearCommand;
use Sugarcrm\UpgradeSpec\Command\GenerateSpecCommand;
use Sugarcrm\UpgradeSpec\Command\SelfRollbackCommand;
use Sugarcrm\UpgradeSpec\Command\SelfUpdateCommand;
use Sugarcrm\UpgradeSpec\Data\Manager;
use Sugarcrm\UpgradeSpec\Data\Provider\SupportSugarcrm;
use Sugarcrm\UpgradeSpec\Element\Provider;
use Sugarcrm\UpgradeSpec\Element\Generator as ElementGenerator;
use Sugarcrm\UpgradeSpec\Element\Section\CoreChanges;
use Sugarcrm\UpgradeSpec\Element\Section\HealthCheck;
use Sugarcrm\UpgradeSpec\Element\Section\ReleaseNotes;
use Sugarcrm\UpgradeSpec\Formatter\MarkdownFormatter;
use Sugarcrm\UpgradeSpec\Helper\File;
use Sugarcrm\UpgradeSpec\Helper\Sugarcrm;
use Sugarcrm\UpgradeSpec\Spec\Generator;
use Sugarcrm\UpgradeSpec\Template\Locator;
use Sugarcrm\UpgradeSpec\Template\Renderer;
use Sugarcrm\UpgradeSpec\Updater\Adapter\HumbugAdapter;
use Sugarcrm\UpgradeSpec\Updater\Updater;
use Symfony\Component\Console\Application;
use Symfony\Component\Dotenv\Dotenv;

class App
{
    /**
     * @var Application
     */
    private $app;

    /**
     * App constructor.
     * @param $name
     * @param $version
     */
    public function __construct($name, $version)
    {
        $this->app = new Application($name, $version);
        $this->initEnvironment();
    }

    /**
     * Application entry point
     */
    public function run()
    {
        $cache = $this->getCache();

        $this->app->add(new GenerateSpecCommand(null, $this->getGenerator($cache), new Sugarcrm(), new File()));
        $this->app->add(new CacheClearCommand(null, $cache));

        if ($this->isUpdateAvailable()) {
            $updater = $this->getUpdater();
            $this->app->add(new SelfUpdateCommand(null, $updater));
            $this->app->add(new SelfRollbackCommand(null, $updater));
        }

        $this->app->run();
    }

    /*
     * Init application environment
     */
    private function initEnvironment()
    {
        $env = new Dotenv;

        $envPath = __DIR__ . '/../.env';
        if (file_exists($envPath)) {
            $env->populate($env->parse(@file_get_contents($envPath), $envPath));
        }

        $envPath = __DIR__ . '/../.env.dist';
        $env->populate($env->parse(@file_get_contents($envPath), $envPath));
    }

    /**
     * Defines if current execution context supports self updates
     * @return string
     */
    private function isUpdateAvailable()
    {
        return getenv('DEV_MODE') || \Phar::running();
    }

    /**
     * Updater factory method
     * @return Updater
     */
    private function getUpdater()
    {
        $strategy = new GithubStrategy();
        $strategy->setPackageName(getenv('PACKAGE_NAME'));
        $strategy->setPharName(getenv('PHAR_BASENAME') . '.phar');
        $strategy->setCurrentLocalVersion($this->app->getVersion());

        $humbugUpdater = new HumbugUpdater();
        $humbugUpdater->setStrategyObject($strategy);

        $path = sys_get_temp_dir() . '/' . getenv('PHAR_BASENAME') . '-old.phar';
        $humbugUpdater->setBackupPath($path);
        $humbugUpdater->setRestorePath($path);

        return new Updater(new HumbugAdapter($humbugUpdater));
    }

    /**
     * Generator factory method
     * @param Cache $cache
     * @return Generator
     */
    private function getGenerator(Cache $cache)
    {
        $specElements = [
            CoreChanges::class,
            ReleaseNotes::class,
            HealthCheck::class
        ];

        $formatter = new MarkdownFormatter();
        $templateRenderer = new Renderer(new Locator(__DIR__ . '/../' . getenv('TEMPLATE_PATH')));
        $dataManager = new Manager(new SupportSugarcrm($cache, new HtmlConverter(['strip_tags' => true])));

        return new Generator(
            new Provider($specElements, $templateRenderer, $dataManager),
            new ElementGenerator($formatter),
            $formatter
        );
    }

    /**
     * Cache factory method
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
