<?php

namespace Sugarcrm\UpgradeSpec\Element\Section;

use Sugarcrm\UpgradeSpec\Element\ElementInterface;
use Sugarcrm\UpgradeSpec\Element\RendererAwareInterface;
use Sugarcrm\UpgradeSpec\Element\RendererAwareTrait;

class CoreChanges implements ElementInterface, RendererAwareInterface
{
    use RendererAwareTrait;

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
        return 3;
    }

    /**
     * @param $version
     * @param $newVersion
     *
     * @return bool
     */
    public static function isRelevantTo($version, $newVersion)
    {
        return true;
    }

    /**
     * @param $version
     * @param $newVersion
     *
     * @return string
     */
    public function getBody($version, $newVersion)
    {
        return $this->renderer->render('core_changes', []);
    }
}
