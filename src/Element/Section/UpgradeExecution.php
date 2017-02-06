<?php

namespace Sugarcrm\UpgradeSpec\Element\Section;

use Sugarcrm\UpgradeSpec\Data\DataAwareInterface;
use Sugarcrm\UpgradeSpec\Data\DataAwareTrait;
use Sugarcrm\UpgradeSpec\Element\ElementInterface;
use Sugarcrm\UpgradeSpec\Context\Upgrade;
use Sugarcrm\UpgradeSpec\Template\RendererAwareInterface;
use Sugarcrm\UpgradeSpec\Template\RendererAwareTrait;

class UpgradeExecution implements ElementInterface, RendererAwareInterface, DataAwareInterface
{
    use RendererAwareTrait, DataAwareTrait;

    /**
     * @return string
     */
    public function getTitle()
    {
        return 'Upgrade your instance';
    }

    /**
     * @return int
     */
    public function getOrder()
    {
        return 5;
    }

    /**
     * @param Upgrade $context
     *
     * @return bool
     */
    public function isRelevantTo(Upgrade $context)
    {
        return true;
    }

    /**
     * @param Upgrade $context
     *
     * @return string
     */
    public function getBody(Upgrade $context)
    {
        return $this->renderer->render('upgrade_execution', [
            'upgrade_execution_howto' => $this->dataManager->getUpgraderInfo($context->getTargetVersion()),
        ]);
    }
}
