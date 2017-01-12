<?php

namespace Sugarcrm\UpgradeSpec;

class Utils
{
    /**
     * Extracts version number from sugarcrm build files
     * @param $path
     * @return string
     */
    public function getBuildVersion($path)
    {
        require realpath($path) . '/sugar_version.php';

        return $sugar_version;
    }

    /**
     * Verifies if given path represents a valid SugarCRM build
     * @param $path
     * @return bool
     */
    public function isSugarcrmBuild($path)
    {
        return $path && file_exists(realpath($path) . '/sugar_version.php');
    }

    /**
     * @param $filename
     * @param $spec
     */
    public function saveToFile($filename, $spec)
    {
        file_put_contents($filename, $spec);
    }
}
