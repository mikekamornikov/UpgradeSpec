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
        $releaseNotes = $this->dataManager->getReleaseNotes($version, $newVersion);

        $features = $devChanges = [];
        foreach ($releaseNotes as $version) {
            if (isset($version['features'])) {
                $features[] = $version['features'];
            }
            if (isset($version['dev_changes'])) {
                $devChanges[] = $version['dev_changes'];
            }
        }

        return $this->renderer->render('release_notes', [
            'features' => implode(PHP_EOL . PHP_EOL, $features),
            'dev_changes' => implode(PHP_EOL . PHP_EOL, $devChanges),
        ]);
    }
}
