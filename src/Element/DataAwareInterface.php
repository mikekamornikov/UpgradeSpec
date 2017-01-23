<?php

namespace Sugarcrm\UpgradeSpec\Element;

use Sugarcrm\UpgradeSpec\Data\Manager;

interface DataAwareInterface
{
    public function setDataManager(Manager $dataManager);
}
