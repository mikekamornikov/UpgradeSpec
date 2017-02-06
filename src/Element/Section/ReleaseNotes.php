<?php

namespace Sugarcrm\UpgradeSpec\Element\Section;

use Sugarcrm\UpgradeSpec\Data\DataAwareInterface;
use Sugarcrm\UpgradeSpec\Data\DataAwareTrait;
use Sugarcrm\UpgradeSpec\Element\ElementInterface;
use Sugarcrm\UpgradeSpec\Context\Upgrade;
use Sugarcrm\UpgradeSpec\Template\RendererAwareInterface;
use Sugarcrm\UpgradeSpec\Template\RendererAwareTrait;

class ReleaseNotes implements ElementInterface, RendererAwareInterface, DataAwareInterface
{
    use RendererAwareTrait, DataAwareTrait;

    /**
     * @return string
     */
    public function getTitle()
    {
        return 'Review release notes';
    }

    /**
     * @return int
     */
    public function getOrder()
    {
        return 1;
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
        return $this->renderer->render('release_notes', [
            'release_notes' => $this->dataManager->getReleaseNotes($context),
        ]);
    }
}
