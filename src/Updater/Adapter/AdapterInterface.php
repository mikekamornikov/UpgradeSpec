<?php

namespace Sugarcrm\UpgradeSpec\Updater\Adapter;

use Sugarcrm\UpgradeSpec\Updater\Updater;

interface AdapterInterface
{
    public function hasUpdate();

    public function getOldVersion();

    public function getNewVersion();

    public function update($stability = Updater::STABILITY_ANY);

    public function rollback();
}
