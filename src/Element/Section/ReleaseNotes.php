<?php

namespace Sugarcrm\UpgradeSpec\Element\Section;

use Sugarcrm\UpgradeSpec\Element\ElementInterface;
use Sugarcrm\UpgradeSpec\Element\ElementTrait;

class ReleaseNotes implements ElementInterface
{
    use ElementTrait;

    /**
     * @return string
     */
    public function getTitle()
    {
        return 'Analyze release notes';
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
     * @param $newVersion
     * @return bool
     */
    public function isRelevantTo($version, $newVersion)
    {
        return true;
    }

    /**
     * @param $version
     * @param $newVersion
     * @return string
     */
    public function getBody($version, $newVersion)
    {
        return $this->renderer->render('release_notes', [
            'release_notes' => $this->dataManager->getReleaseNotes($version, $newVersion)
        ]);
    }
}
