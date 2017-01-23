<?php

namespace Sugarcrm\UpgradeSpec\Purifier;

interface PurifierInterface
{
    /**
     * Purifies given data.
     *
     * @param $data
     *
     * @return mixed
     */
    public function purify($data);
}
