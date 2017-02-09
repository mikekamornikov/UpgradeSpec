<?php

namespace Sugarcrm\UpgradeSpec\Data;

use Sugarcrm\UpgradeSpec\Context\Upgrade;
use Sugarcrm\UpgradeSpec\Version\OrderedList;
use Sugarcrm\UpgradeSpec\Version\Version;

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
     * @param string $flav
     *
     * @return OrderedList
     */
    public function getVersions($flav)
    {
        $versions = $this->provider->getVersions($flav);
        if (!count($versions)) {
            throw new \RuntimeException(sprintf('No "%s" versions available', $flav));
        }

        return $versions;
    }

    /**
     * Gets the latest available SugarCRM version with given flav and base version.
     *
     * Examples: 7.6.1 -> 7.6.1.0, 7.7 -> 7.7.1, 7.8 -> 7.8.0.0
     *
     * @param string $flav
     * @param Version|null $baseVersion
     *
     * @return Version
     */
    public function getLatestVersion($flav, Version $baseVersion = null)
    {
        $versions = $this->getVersions($flav);

        // the latest available
        if (is_null($baseVersion)) {
            return $versions->last();
        }

        // is minor bugfix version
        if ($baseVersion->isFull()) {
            if (!$versions->contains($baseVersion)) {
                throw new \InvalidArgumentException(sprintf('Unknown version: %s', $baseVersion));
            }

            return $baseVersion;
        }

        /**
         * all versions with $baseVersion base
         * for example: 7.6.1 -> [7.6.1, 7.6.1.0, 7.6.1.1], 7.6 -> [7.6.1.0, 7.6.1.1, 7.6.2].
         */
        $minors = $versions->filter(function (Version $version) use ($baseVersion) {
            return $version->isChildOf($baseVersion) || $version->isEqualTo($baseVersion);
        });

        if (!count($minors)) {
            throw new \InvalidArgumentException(sprintf('No minor versions available for version: %s', $baseVersion));
        }

        return $minors->last();
    }

    /**
     * Gets release notes for all versions from given range.
     *
     * @param Upgrade $context
     *
     * @return array
     */
    public function getReleaseNotes(Upgrade $context)
    {
        $versions = $this->getVersionRange($context);

        return $this->provider->getReleaseNotes($context->getBuildFlav(), $versions);
    }

    /**
     * Gets all required information to perform health check.
     *
     * @param Version $version
     *
     * @return mixed
     */
    public function getHealthCheckInfo(Version $version)
    {
        return $this->provider->getHealthCheckInfo($version);
    }

    /**
     * Gets all required information to perform upgrade.
     *
     * @param Version $version
     *
     * @return mixed
     */
    public function getUpgraderInfo(Version $version)
    {
        return $this->provider->getUpgraderInfo($version);
    }

    /**
     * Gets the list of potentially broken customizations (changed and deleted files)
     *
     * @param Upgrade $context
     *
     * @return mixed
     */
    public function getPotentiallyBrokenCustomizations(Upgrade $context)
    {
        return $this->provider->getPotentiallyBrokenCustomizations($context);
    }

    /**
     * Gets the lists of upgrade steps for the given source
     *
     * @param Upgrade $context
     *
     * @return mixed
     */
    public function getUpgradeSteps(Upgrade $context)
    {
        return $this->provider->getUpgradeSteps($context);
    }

    /**
     * Gets all available versions from given range ($from < version <= $to).
     *
     * @param Upgrade $context
     *
     * @return OrderedList
     */
    private function getVersionRange(Upgrade $context)
    {
        $from = (string) $context->getBuildVersion()->getFull();
        $to = (string) $context->getTargetVersion()->getFull();

        return $this->getVersions($context->getBuildFlav())->filter(function (Version $version) use ($from, $to) {
            return version_compare((string) $version, $from, '>')
                && version_compare((string) $version, $to, '<=');
        });
    }
}
