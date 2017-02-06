<?php

namespace Sugarcrm\UpgradeSpec\Element\Section;

use Sugarcrm\UpgradeSpec\Data\DataAwareInterface;
use Sugarcrm\UpgradeSpec\Data\DataAwareTrait;
use Sugarcrm\UpgradeSpec\Element\ElementInterface;
use Sugarcrm\UpgradeSpec\Context\Upgrade;
use Sugarcrm\UpgradeSpec\Template\RendererAwareInterface;
use Sugarcrm\UpgradeSpec\Template\RendererAwareTrait;

class HealthCheck implements ElementInterface, RendererAwareInterface, DataAwareInterface
{
    use RendererAwareTrait, DataAwareTrait;

    /**
     * @return string
     */
    public function getTitle()
    {
        return 'Run Health Check and fix all errors';
    }

    /**
     * @return int
     */
    public function getOrder()
    {
        return 4;
    }

    /**
     * @param Upgrade $context
     *
     * @return bool
     */
    public function isRelevantTo(Upgrade $context)
    {
        return version_compare($context->getTargetVersion(), '7.0', '>=');
    }

    /**
     * @param Upgrade $context
     *
     * @return string
     */
    public function getBody(Upgrade $context)
    {
        return $this->renderer->render('health_check', [
            'health_check_howto' => $this->dataManager->getHealthCheckInfo($context->getTargetVersion()),
        ]);
    }
}
