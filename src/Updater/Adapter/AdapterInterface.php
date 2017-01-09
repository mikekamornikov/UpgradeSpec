<?php

namespace Sugarcrm\UpgradeSpec\Updater\Adapter;

use Sugarcrm\UpgradeSpec\Updater\UpdaterInterface;

interface AdapterInterface
{
    public function hasUpdate();

    public function getOldVersion();

    public function getNewVersion();

    public function update($stability = UpdaterInterface::STABILITY_ANY);

    public function rollback();
}
