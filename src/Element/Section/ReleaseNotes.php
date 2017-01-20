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
        return 'Get and analyze release notes';
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
        $features = $this->dataManager->getFeatureEnhancements($version, $newVersion);
        $devChanges = $this->dataManager->getDevelopmentChanges($version, $newVersion);

        return $this->renderer->render('release_notes', [
            'features' => implode(PHP_EOL . PHP_EOL, $features),
            'devChanges' => implode(PHP_EOL . PHP_EOL, $devChanges),
        ]);
    }
}
