<?php

namespace Sugarcrm\UpgradeSpec\Data;

interface DataAwareInterface
{
    /**
     * @param Manager $dataManager
     *
     * @return void
     */
    public function setDataManager(Manager $dataManager);
}
