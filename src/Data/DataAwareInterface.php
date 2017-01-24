<?php

namespace Sugarcrm\UpgradeSpec\Data;

interface DataAwareInterface
{
    public function setDataManager(Manager $dataManager);
}
