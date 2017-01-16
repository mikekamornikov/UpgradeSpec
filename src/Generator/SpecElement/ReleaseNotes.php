<?php

namespace Sugarcrm\UpgradeSpec\Generator\SpecElement;

class ReleaseNotes extends SpecElement implements SpecElementInterface
{
    /**
     * @return string
     */
    public function getTitle()
    {
        return 'Get release notes for newest versions';
    }

    /**
     * @return int
     */
    public function getOrder()
    {
       return 2;
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
