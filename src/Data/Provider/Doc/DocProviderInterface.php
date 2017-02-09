<?php

namespace Sugarcrm\UpgradeSpec\Data\Provider\Doc;

use Sugarcrm\UpgradeSpec\Data\Provider\ProviderInterface;
use Sugarcrm\UpgradeSpec\Version\OrderedList;
use Sugarcrm\UpgradeSpec\Version\Version;

interface DocProviderInterface extends ProviderInterface
{
    /**
     * Get all available SugarCRM versions (sorted ASC).
     *
     * @param $flav
     *
     * @return OrderedList
     */
    public function getVersions($flav);

    /**
     * Get release notes for all available versions from given range.
     *
     * @param $flav
     * @param OrderedList $versions
     *
     * @return array
     */
    public function getReleaseNotes($flav, OrderedList $versions);

    /**
     * Gets all required information to perform health check.
     *
     * @param Version $version
     *
     * @return mixed
     */
    public function getHealthCheckInfo(Version $version);

    /**
     * Gets all required information to perform upgrade.
     *
     * @param Version $version
     *
     * @return mixed
     */
    public function getUpgraderInfo(Version $version);
}
