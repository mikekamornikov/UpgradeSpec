<?php

namespace Sugarcrm\UpgradeSpec\Helper;

class File
{
    /**
     * @param $filename
     * @param $spec
     */
    public function saveToFile($filename, $spec)
    {
        file_put_contents($filename, $spec);
    }
}
