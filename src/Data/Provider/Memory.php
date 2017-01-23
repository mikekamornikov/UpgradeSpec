<?php

namespace Sugarcrm\UpgradeSpec\Data\Provider;

class Memory implements ProviderInterface
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
     * @return mixed
     */
    public function getVersions()
    {
        return $this->get('versions', []);
    }

    /**
     * Get release notes for all available versions from given range.
     *
     * @param array $versions
     *
     * @return mixed
     */
    public function getReleaseNotes(array $versions)
    {
        return $this->get('release_notes', []);
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
