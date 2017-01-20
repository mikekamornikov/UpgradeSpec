<?php

namespace Sugarcrm\UpgradeSpec\Data;

use Sugarcrm\UpgradeSpec\Data\Provider\ProviderInterface;

class Manager
{
    /**
     * @var ProviderInterface
     */
    private $provider;

    /**
     * Manager constructor.
     * @param ProviderInterface $provider
     */
    public function __construct(ProviderInterface $provider)
    {
        $this->provider = $provider;
    }

    /**
     * Get all available SugarCRM versions (sorted ASC)
     * @return mixed
     */
    public function getVersions()
    {
        $versions = $this->provider->getVersions();
        if (!$versions) {
            throw new \RuntimeException('No versions available');
        }

        return $versions;
    }

    /**
     * Get the latest available SugarCRM version
     * @return mixed
     */
    public function getLatestVersion()
    {
        $versions = $this->getVersions();

        return end($versions);
    }

    /**
     * Get feature enhancements for all versions from given range
     * @param $from
     * @param $to
     * @return mixed
     */
    public function getFeatureEnhancements($from, $to)
    {
        $versions = $this->getVersionRange($from, $to);

        return $this->provider->getFeatureEnhancements($versions);
    }

    /**
     * Get development changes for all versions from given range
     * @param $from
     * @param $to
     * @return mixed
     */
    public function getDevelopmentChanges($from, $to)
    {
        $versions = $this->getVersionRange($from, $to);

        return $this->provider->getDevelopmentChanges($versions);
    }

    /**
     * Get all available versions from given range ($from < version <= $to)
     * @param $from
     * @param $to
     * @return array
     */
    private function getVersionRange($from, $to)
    {
        $versions = [];
        foreach ($this->getVersions() as $version) {
            if (version_compare($version, $from, '>') && version_compare($version, $to, '<=')) {
                $versions[] = $version;
            }
        }

        return $versions;
    }
}
