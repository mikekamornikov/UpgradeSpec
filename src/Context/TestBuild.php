<?php

namespace Sugarcrm\UpgradeSpec\Context;

use Sugarcrm\UpgradeSpec\Helper\Sugarcrm;
use Sugarcrm\UpgradeSpec\Version\Version;

class TestBuild extends Build
{
    /**
     * @param $source
     */
    protected function validateSource($source)
    {
        // no validation
    }
}
