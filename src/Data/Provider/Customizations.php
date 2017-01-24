<?php

namespace Sugarcrm\UpgradeSpec\Data\Provider;

class Customizations
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
        return $this->get($flav . '_release_notes', []);
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
        return isset($this->data[$key]) ? $this->data[$key] : $default;
    }
}
