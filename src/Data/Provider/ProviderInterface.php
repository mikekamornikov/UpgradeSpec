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
     * Get feature enhancements for all available versions from given range
     * @param array $versions
     * @return mixed
     */
    public function getFeatureEnhancements(array $versions);

    /**
     * Get development changes for all available versions from given range
     * @param array $versions
     * @return mixed
     */
    public function getDevelopmentChanges(array $versions);
}
