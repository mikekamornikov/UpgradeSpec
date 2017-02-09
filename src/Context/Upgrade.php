<?php

namespace Sugarcrm\UpgradeSpec\Context;

use Sugarcrm\UpgradeSpec\Version\Version;

final class Upgrade
{
    /**
     * @var Build
     */
    private $build;

    /**
     * @var Target
     */
    private $target;

    /**
     * Upgrade constructor.
     *
     * @param $build
     * @param $target
     */
    public function __construct(Build $build, Target $target)
    {
        $this->build = $build;
        $this->target = $target;
    }

    /**
     * @return Version
     */
    public function getBuildVersion()
    {
        return $this->build->getVersion();
    }

    /**
     * @return string
     */
    public function getBuildFlav()
    {
        return $this->build->getFlav();
    }

    /**
     * @return string
     */
    public function getBuildPath()
    {
        return $this->build->getSource();
    }

    /**
     * @return Version
     */
    public function getTargetVersion()
    {
        return $this->target->getVersion();
    }

    /**
     * @return string
     */
    public function getTargetFlav()
    {
        return $this->target->getFlav();
    }

    /**
     * @return string
     */
    public function getTargetPath()
    {
        return $this->target->getSource();
    }

    /**
     * Returns possible file name for current context.
     *
     * @return string
     */
    public function asFilename()
    {
        return sprintf('upgrade_%s_to_%s', $this->build, $this->target);
    }

    /**
     * Returns Upgrade string representation.
     *
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s -> %s', $this->build, $this->target);
    }
}
