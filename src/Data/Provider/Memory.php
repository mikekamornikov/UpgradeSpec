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
     * Get all available SugarCRM versions (sorted ASC)
     * @return mixed
     */
    public function getVersions()
    {
//        return ['6.7', '7.7', '7.7.1', '7.8'];
        return $this->data['versions'];
    }

    /**
     * Get release notes for all available versions from given range
     * @param array $versions
     * @return mixed
     */
    public function getReleaseNotes(array $versions)
    {
        return $this->data['release_notes'];
    }
}
