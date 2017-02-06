<?php

namespace Sugarcrm\UpgradeSpec\Context;

use Sugarcrm\UpgradeSpec\Version\Version;

class Metadata
{
    /**
     * @var string
     */
    private $version;

    /**
     * @var string
     */
    private $flav;

    /**
     * @var string
     */
    private $source;

    /**
     * Metadata constructor.
     *
     * @param $version
     * @param $flav
     * @param string $source
     */
    public function __construct(Version $version, $flav, $source)
    {
        $this->version = $version;
        $this->flav = $flav;
        $this->source = $source;
    }

    /**
     * @return string
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * @return string
     */
    public function getFlav()
    {
        return $this->flav;
    }

    /**
     * @return string
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * Returns Context string representation.
     *
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s(%s)', $this->version, $this->flav);
    }
}
