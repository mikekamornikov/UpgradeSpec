<?php

namespace Sugarcrm\UpgradeSpec\Element\Section;

use Sugarcrm\UpgradeSpec\Data\DataAwareInterface;
use Sugarcrm\UpgradeSpec\Data\DataAwareTrait;
use Sugarcrm\UpgradeSpec\Element\ElementInterface;
use Sugarcrm\UpgradeSpec\Spec\Context;
use Sugarcrm\UpgradeSpec\Template\RendererAwareInterface;
use Sugarcrm\UpgradeSpec\Template\RendererAwareTrait;

class CheckCustomizations implements ElementInterface, RendererAwareInterface, DataAwareInterface
{
    use RendererAwareTrait, DataAwareTrait;

    /**
     * @return string
     */
    public function getTitle()
    {
        return 'Analyze customizations';
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
        return true;
    }

    /**
     * @param Context $context
     *
     * @return string
     */
    public function getBody(Context $context)
    {
        return $this->renderer->render('check_customizations', [
            'check_customizations' => $this->dataManager->getListOfCustomizations($context),
        ]);
    }
}
