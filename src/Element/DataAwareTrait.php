<?php

namespace Sugarcrm\UpgradeSpec\Element;

use Sugarcrm\UpgradeSpec\Data\Manager;

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
