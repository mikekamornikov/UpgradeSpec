<?php

namespace Sugarcrm\UpgradeSpec;

use Humbug\SelfUpdate\Strategy\GithubStrategy;
use Humbug\SelfUpdate\Updater as HumbugUpdater;
use Sugarcrm\UpgradeSpec\Command\GenerateSpecCommand;
use Sugarcrm\UpgradeSpec\Command\SelfRollbackCommand;
use Sugarcrm\UpgradeSpec\Command\SelfUpdateCommand;
use Sugarcrm\UpgradeSpec\Formatter\MarkdownFormatter;
use Sugarcrm\UpgradeSpec\Generator\Configurator;
use Sugarcrm\UpgradeSpec\Generator\Generator;
use Sugarcrm\UpgradeSpec\Generator\SpecElement\CoreChanges;
use Sugarcrm\UpgradeSpec\Generator\SpecElementGenerator;
use Sugarcrm\UpgradeSpec\Locator\TemplateLocator;
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
        $this->app->add(new GenerateSpecCommand(null, $this->getGeneratorObject(), new Utils));

        if ($this->isUpdateAvailable()) {
            $this->app->add(new SelfUpdateCommand(null, $this->getUpdaterObject()));
            $this->app->add(new SelfRollbackCommand(null, $this->getUpdaterObject()));
        }

        $this->app->run();
    }

    /**
     * Configure commands
     */
    private function initEnvironment()
    {
        $env = new Dotenv;

        // source custom .env file
        $envPath = __DIR__ . '/../.env';
        if (file_exists($envPath)) {
            $env->populate($env->parse(file_get_contents($envPath), $envPath));
        }

        // source dist .env file
        $envPath = __DIR__ . '/../.env.dist';
        $env->populate($env->parse(file_get_contents($envPath), $envPath));
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
     * @return Updater
     */
    private function getUpdaterObject()
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

    private function getGeneratorObject()
    {
        $templateLocator = new TemplateLocator(__DIR__ . '/Templates');
        $specElements = [
            new CoreChanges($templateLocator)
        ];

        $formatter = new MarkdownFormatter();

        return new Generator(new Configurator($specElements), new SpecElementGenerator($formatter), $formatter);
    }
}
