<?php

namespace Sugarcrm\UpgradeSpec\Data\Provider;

interface ProviderInterface
{
    /**
     * Get all available SugarCRM versions (sorted ASC)
     * @return mixed
     */
    public function getVersions();

    /**
     * Get release notes for all available versions from given range
     * @param array $versions
     * @return mixed
     */
    public function getReleaseNotes(array $versions);
}
