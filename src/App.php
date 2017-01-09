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
    const VERSION = '@package_version@';
    const PACKAGE_NAME = 'mikekamornikov/uspec';
    const NAME = 'uspec';

    /**
     * Application entry point
     */
    public function run()
    {
        $app = new Application('SugarCRM upgrade spec generator', self::VERSION);

        $app->add(new GenerateSpecCommand);
        $app->add(new SelfUpdateCommand(null, $this->getUpdaterObject()));
        $app->add(new SelfRollbackCommand(null, $this->getUpdaterObject()));

        $app->run();
    }

    /**
     * @return Updater
     */
    private function getUpdaterObject()
    {
        $strategy = new GithubStrategy();
        $strategy->setPackageName(self::PACKAGE_NAME);
        $strategy->setPharName(self::NAME . '.phar');
        $strategy->setCurrentLocalVersion(self::VERSION);

        $humbugUpdater = new HumbugUpdater();
        $humbugUpdater->setStrategyObject($strategy);

        $path = sys_get_temp_dir() . '/' . self::NAME . '-old.phar';
        $humbugUpdater->setBackupPath($path);
        $humbugUpdater->setRestorePath($path);

        return new Updater(new HumbugAdapter($humbugUpdater));
    }
}
