<?php

namespace Sugarcrm\UpgradeSpec\Data;

use Sugarcrm\UpgradeSpec\Spec\Context;

class Manager
{
    /**
     * @var ProviderChain
     */
    private $provider;

    /**
     * Manager constructor.
     *
     * @param ProviderChain $provider
     */
    public function __construct(ProviderChain $provider)
    {
        $this->provider = $provider;
    }

    /**
     * Gets all available SugarCRM versions (sorted ASC).
     *
     * @param $flav
     *
     * @return mixed
     */
    public function getVersions($flav)
    {
        $versions = $this->provider->getVersions($flav);
        if (!$versions) {
            throw new \RuntimeException(sprintf('No %s versions available', $flav));
        }

        return $versions;
    }

    /**
     * Gets the latest available SugarCRM version with given flav and base version.
     *
     * Examples: 7.6.1 -> 7.6.1.0, 7.7 -> 7.7.1, 7.8 -> 7.8.0.0
     *
     * @param $flav
     * @param null $baseVersion
     *
     * @return mixed
     */
    public function getLatestVersion($flav, $baseVersion = null)
    {
        $versions = $this->getVersions($flav);

        // the latest available
        if (!$baseVersion) {
            return end($versions);
        }

        // is minor bugfix version
        $versionParts = explode('.', $baseVersion);
        if (isset($versionParts[3])) {
            if (!in_array($baseVersion, $versions)) {
                throw new \InvalidArgumentException(sprintf('Unknown version: %s', $baseVersion));
            }

            return $baseVersion;
        }

        /**
         * all versions with $baseVersion base
         * for example: 7.6.1 -> [7.6.1.0, 7.6.1.1], 7.6 -> [7.6.1.0, 7.6.1.1, 7.6.2].
         */
        $minors = array_filter($versions, function ($minor) use ($baseVersion) {
            return implode('.', array_slice(explode('.', $minor), 0, count(explode('.', $baseVersion)))) === $baseVersion;
        });

        if (empty($minors)) {
            throw new \InvalidArgumentException(sprintf('No minor versions available for version: %s', $baseVersion));
        }

        return end($minors);
    }

    /**
     * Gets release notes for all versions from given range.
     *
     * @param Context $context
     *
     * @return mixed
     */
    public function getReleaseNotes(Context $context)
    {
        $versions = $this->getVersionRange($context);

        return $this->provider->getReleaseNotes($context->getFlav(), $versions);
    }

    /**
     * Gets all required information to perform health check.
     *
     * @param $version
     *
     * @return mixed
     */
    public function getHealthCheckInfo($version)
    {
        return $this->provider->getHealthCheckInfo($version);
    }

    /**
     * Gets all required information to perform upgrade.
     *
     * @param $version
     *
     * @return mixed
     */
    public function getUpgraderInfo($version)
    {
        return $this->provider->getUpgraderInfo($version);
    }

    /**
     * Gets all available versions from given range ($from < version <= $to).
     *
     * @param Context $context
     *
     * @return array
     */
    private function getVersionRange(Context $context)
    {
        $versionParts = explode('.', $context->getBuildVersion());
        $oldVersion = implode('.', array_merge($versionParts, array_fill(0, 4 - count($versionParts), '0')));
        $newVersion = $context->getUpgradeVersion();

        $versions = [];
        foreach ($this->getVersions($context->getFlav()) as $version) {
            if (version_compare($version, $oldVersion, '>') && version_compare($version, $newVersion, '<=')) {
                $versions[] = $version;
            }
        }

        return $versions;
    }
}
