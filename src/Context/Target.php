<?php

namespace Sugarcrm\UpgradeSpec\Context;

use Sugarcrm\UpgradeSpec\Version\Version;

final class Target extends Metadata
{
    /**
     * Target constructor.
     *
     * @param $version
     * @param $flav
     * @param string $source
     */
    public function __construct(Version $version, $flav, $source = '')
    {
        parent::__construct($version, $flav, $source);
    }
}
