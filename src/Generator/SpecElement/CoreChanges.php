<?php

namespace Sugarcrm\UpgradeSpec\Generator\SpecElement;

class CoreChanges extends SpecElement implements SpecElementInterface
{
    /**
     * @return string
     */
    public function getTitle()
    {
        return 'Backup or rewrite core changes';
    }

    /**
     * @return int
     */
    public function getOrder()
    {
        return 1;
    }

    /**
     * @param $version
     * @return bool
     */
    public function isRelevantTo($version)
    {
        return true;
    }

    /**
     * @return string
     */
    public function getBody()
    {
        return $this->render();
    }
}
