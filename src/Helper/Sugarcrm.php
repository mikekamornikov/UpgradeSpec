<?php

namespace Sugarcrm\UpgradeSpec\Helper;

class Sugarcrm
{
    /**
     * Extracts version number from sugarcrm build files.
     *
     * @param $path
     *
     * @return string
     */
    public function getBuildVersion($path)
    {
        if (!defined('sugarEntry')) {
            define('sugarEntry', true);
        }

        require realpath($path) . '/sugar_version.php';

        return $sugar_version;
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
