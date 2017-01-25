<?php

namespace Sugarcrm\UpgradeSpec\Element\Section;

use Sugarcrm\UpgradeSpec\Element\ElementInterface;
use Sugarcrm\UpgradeSpec\Spec\Context;
use Sugarcrm\UpgradeSpec\Template\RendererAwareInterface;
use Sugarcrm\UpgradeSpec\Template\RendererAwareTrait;

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
        return 4;
    }

    /**
     * @param Context $context
     *
     * @return bool
     */
    public static function isRelevantTo(Context $context)
    {
        return version_compare($context->getUpgradeVersion(), '7.0', '>=');
    }

    /**
     * @param Context $context
     *
     * @return string
     */
    public function getBody(Context $context)
    {
        return $this->renderer->render('health_check', []);
    }
}
