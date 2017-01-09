<?php

namespace Sugarcrm\UpgradeSpec\Updater;

interface UpdaterInterface
{
    const STABILITY_STABLE = 'stable';
    const STABILITY_UNSTABLE = 'unstable';
    const STABILITY_ANY = 'any';

    public function hasUpdate();

    public function getOldVersion();

    public function getNewVersion();

    public function update($stability = self::STABILITY_ANY);

    public function rollback();
}
