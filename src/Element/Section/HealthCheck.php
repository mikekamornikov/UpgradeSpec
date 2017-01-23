<?php

namespace Sugarcrm\UpgradeSpec\Element\Section;

use Sugarcrm\UpgradeSpec\Element\ElementInterface;
use Sugarcrm\UpgradeSpec\Element\RendererAwareInterface;
use Sugarcrm\UpgradeSpec\Element\RendererAwareTrait;

class HealthCheck implements ElementInterface, RendererAwareInterface
{
    use RendererAwareTrait;

    /**
     * @return string
     */
    public function getTitle()
    {
        return 'Run health checker and fix all errors';
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
     * @param $newVersion
     *
     * @return bool
     */
    public static function isRelevantTo($version, $newVersion)
    {
        return version_compare($newVersion, '7.0', '>=');
    }

    /**
     * @param $version
     * @param $newVersion
     *
     * @return string
     */
    public function getBody($version, $newVersion)
    {
        return $this->renderer->render('health_check', []);
    }
}
