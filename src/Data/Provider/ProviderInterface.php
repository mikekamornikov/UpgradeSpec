<?php

namespace Sugarcrm\UpgradeSpec\Data\Provider;

interface ProviderInterface
{
    /**
     * Get all available SugarCRM versions (sorted ASC).
     *
     * @param $flav
     *
     * @return mixed
     */
    public function getVersions($flav);

    /**
     * Get release notes for all available versions from given range.
     *
     * @param $flav
     * @param array $versions
     *
     * @return mixed
     */
    public function getReleaseNotes($flav, array $versions);

    /**
     * Gets all required information to perform health check
     *
     * @param $version
     *
     * @return mixed
     */
    public function getHealthCheckInfo($version);
}
