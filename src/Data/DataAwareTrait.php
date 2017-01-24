<?php

namespace Sugarcrm\UpgradeSpec\Data;

trait DataAwareTrait
{
    /**
     * @var Manager
     */
    private $dataManager;

    /**
     * @param Manager $dataManager
     */
    public function setDataManager(Manager $dataManager)
    {
        $this->dataManager = $dataManager;
    }
}
