<?php

namespace Sugarcrm\UpgradeSpec\Data\Provider;

use Sugarcrm\UpgradeSpec\Data\Provider\Doc\DocProviderInterface;
use Sugarcrm\UpgradeSpec\Data\Provider\SourceCode\SourceCodeProviderInterface;
use Sugarcrm\UpgradeSpec\Context\Upgrade;

class Memory implements DocProviderInterface, SourceCodeProviderInterface
{
    /**
     * @var array
     */
    private $data;

    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

    /**
     * Get all available SugarCRM versions (sorted ASC).
     *
     * @param $flav
     *
     * @return mixed
     */
    public function getVersions($flav)
    {
        return $this->get($flav . '_versions', []);
    }

    /**
     * Get release notes for all available versions from given range.
     *
     * @param $flav
     * @param array $versions
     *
     * @return mixed
     */
    public function getReleaseNotes($flav, array $versions)
    {
        return array_map(function ($version) use ($flav) {
            return $this->get(sprintf('%s_%s_release_notes', $flav, $version), '');
        }, $versions);
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
        return $this->get($version . '_health_check', '');
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
        return $this->get($version . '_upgrader', '');
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
        return $this->get($context . '_customizations', [[], []]);
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
        return $this->get($context . '_upgrade_steps', []);
    }

    /**
     * Gets data from memory by key.
     *
     * @param $key
     * @param null $default
     *
     * @return mixed|null
     */
    private function get($key, $default = null)
    {
        $key = mb_strtolower($key);

        return isset($this->data[$key]) ? $this->data[$key] : $default;
    }
}
