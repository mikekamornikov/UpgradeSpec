<?php

namespace Sugarcrm\UpgradeSpec;

use Humbug\SelfUpdate\Strategy\GithubStrategy;
use Humbug\SelfUpdate\Updater as HumbugUpdater;
use Sugarcrm\UpgradeSpec\Command\GenerateSpecCommand;
use Sugarcrm\UpgradeSpec\Command\SelfRollbackCommand;
use Sugarcrm\UpgradeSpec\Command\SelfUpdateCommand;
use Sugarcrm\UpgradeSpec\Updater\Adapter\HumbugAdapter;
use Sugarcrm\UpgradeSpec\Updater\Updater;
use Symfony\Component\Console\Application;

class App
{
    const PACKAGE_NAME = 'mikekamornikov/uspec';
    const NAME = 'uspec';
    
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
        $this->init();
    }

    /**
     * Application entry point
     */
    public function run()
    {
        $this->app->run();
    }

    /**
     * Configure commands
     */
    private function init()
    {
        $this->app->add(new GenerateSpecCommand);

        if ($this->isUpdateAvailable()) {
            $this->app->add(new SelfUpdateCommand(null, $this->getUpdaterObject()));
            $this->app->add(new SelfRollbackCommand(null, $this->getUpdaterObject()));
        }
    }

    /**
     * Defines if current execution context supports self updates
     * @return string
     */
    private function isUpdateAvailable()
    {
        return DEV_MODE || \Phar::running();
    }

    /**
     * @return Updater
     */
    private function getUpdaterObject()
    {
        $strategy = new GithubStrategy();
        $strategy->setPackageName(self::PACKAGE_NAME);
        $strategy->setPharName(self::NAME . '.phar');
        $strategy->setCurrentLocalVersion($this->app->getVersion());

        $humbugUpdater = new HumbugUpdater();
        $humbugUpdater->setStrategyObject($strategy);

        $path = sys_get_temp_dir() . '/' . self::NAME . '-old.phar';
        $humbugUpdater->setBackupPath($path);
        $humbugUpdater->setRestorePath($path);

        return new Updater(new HumbugAdapter($humbugUpdater));
    }
}
