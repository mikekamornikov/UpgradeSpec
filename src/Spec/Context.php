<?php

namespace Sugarcrm\UpgradeSpec\Spec;

final class Context
{
    /**
     * @var string
     */
    private $buildVersion;

    /**
     * @var string
     */
    private $upgradeVersion;

    /**
     * @var string
     */
    private $flav;

    /**
     * Context constructor.
     *
     * @param $buildVersion
     * @param $upgradeVersion
     * @param $flav
     */
    public function __construct($buildVersion, $upgradeVersion, $flav)
    {
        $this->buildVersion = $buildVersion;
        $this->upgradeVersion = $upgradeVersion;
        $this->flav = $flav;
    }

    /**
     * Returns Context string representation.
     *
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s -> %s (%s)', $this->buildVersion, $this->upgradeVersion, $this->flav);
    }

    /**
     * @return string
     */
    public function getBuildVersion()
    {
        return $this->buildVersion;
    }

    /**
     * @return string
     */
    public function getUpgradeVersion()
    {
        return $this->upgradeVersion;
    }

    /**
     * @return string
     */
    public function getFlav()
    {
        return $this->flav;
    }

    /**
     * Returns possible file name for current context.
     *
     * @return string
     */
    public function asFilename()
    {
        return sprintf('upgrade_%s_to_%s_%s', $this->buildVersion, $this->upgradeVersion, $this->flav);
    }
}
