<?php

namespace Sugarcrm\UpgradeSpec\Helper;

use Sugarcrm\UpgradeSpec\Version\Version;

class Sugarcrm
{
    /**
     * Extracts version number from sugarcrm build files.
     *
     * @param $path
     *
     * @return Version
     */
    public function getBuildVersion($path)
    {
        if (!defined('sugarEntry')) {
            define('sugarEntry', true);
        }

        require realpath($path) . '/sugar_version.php';

        return new Version($sugar_version);
    }

    /**
     * Extracts flav from sugarcrm build files.
     *
     * @param $path
     *
     * @return string
     */
    public function getBuildFlav($path)
    {
        if (!defined('sugarEntry')) {
            define('sugarEntry', true);
        }

        require realpath($path) . '/sugar_version.php';

        return $sugar_flavor;
    }

    /**
     * Verifies if given path represents a valid SugarCRM build.
     *
     * @param $path
     *
     * @return bool
     */
    public function isSugarcrmBuild($path)
    {
        return $path && file_exists(realpath($path) . '/sugar_version.php');
    }
}
