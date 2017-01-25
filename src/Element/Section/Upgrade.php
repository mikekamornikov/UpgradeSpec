<?php

namespace Sugarcrm\UpgradeSpec\Element\Section;

use Sugarcrm\UpgradeSpec\Data\DataAwareInterface;
use Sugarcrm\UpgradeSpec\Data\DataAwareTrait;
use Sugarcrm\UpgradeSpec\Element\ElementInterface;
use Sugarcrm\UpgradeSpec\Spec\Context;
use Sugarcrm\UpgradeSpec\Template\RendererAwareInterface;
use Sugarcrm\UpgradeSpec\Template\RendererAwareTrait;

class Upgrade implements ElementInterface, RendererAwareInterface, DataAwareInterface
{
    use RendererAwareTrait, DataAwareTrait;

    /**
     * @return string
     */
    public function getTitle()
    {
        return 'Perform upgrade';
    }

    /**
     * @return int
     */
    public function getOrder()
    {
        return 5;
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
        return '';
//        return $this->renderer->render('release_notes', [
//            'release_notes' => $this->dataManager->getReleaseNotes($context),
//        ]);
    }
}
