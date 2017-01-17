<?php

namespace Sugarcrm\UpgradeSpec\Generator\Element;

class ReleaseNotes implements ElementInterface
{
    use ElementTrait;

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
        return $this->renderer->render('release_notes', []);
    }
}
