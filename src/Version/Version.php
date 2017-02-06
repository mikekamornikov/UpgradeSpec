<?php

namespace Sugarcrm\UpgradeSpec\Version;

final class Version
{
    /**
     * @var string
     */
    private $version;

    /**
     * Version constructor.
     *
     * @param $version
     */
    public function __construct($version)
    {
        if (!preg_match('/\d+(\.\d+){1,3}/', $version)) {
            throw new \InvalidArgumentException(sprintf('"%s" is not a valid SugarCRM version', $version));
        }

        $this->version = $version;
    }

    /**
     * @return bool
     */
    public function isMajor()
    {
        return count(explode('.', $this->version)) <= 2;
    }

    /**
     * @return bool
     */
    public function isMinor()
    {
        return !$this->isMajor();
    }

    /**
     * @return string
     */
    public function getFull()
    {
        $parts = explode('.', $this->version);
        if (count($parts) == 4) {
            return $this->version;
        }

        $parts = array_merge($parts, array_fill(0, 4 - count($parts), '0'));

        return implode('.', $parts);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->version;
    }
}
