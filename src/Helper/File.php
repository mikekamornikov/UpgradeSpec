<?php

namespace Sugarcrm\UpgradeSpec\Helper;

class File
{
    /**
     * @param $filename
     * @param $spec
     *
     * @return int
     */
    public function saveToFile($filename, $spec)
    {
        return file_put_contents($filename, $spec);
    }
}
