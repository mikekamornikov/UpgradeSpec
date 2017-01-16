<?php

namespace Sugarcrm\UpgradeSpec\Generator\SpecElement;

use Sugarcrm\UpgradeSpec\Generator\SpecElement\SpecElementInterface;

class ReleaseNotes implements SpecElementInterface
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
        return "Feature Enhancements\nFixed Issues\nKnown Issues\nDeveloper\nAdditional Product Information";
    }

}
