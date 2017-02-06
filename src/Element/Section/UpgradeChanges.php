<?php

namespace Sugarcrm\UpgradeSpec\Element\Section;

use Sugarcrm\UpgradeSpec\Data\DataAwareInterface;
use Sugarcrm\UpgradeSpec\Data\DataAwareTrait;
use Sugarcrm\UpgradeSpec\Element\ElementInterface;
use Sugarcrm\UpgradeSpec\Context\Upgrade;
use Sugarcrm\UpgradeSpec\Template\RendererAwareInterface;
use Sugarcrm\UpgradeSpec\Template\RendererAwareTrait;
use Symfony\Component\Finder\Finder;

class UpgradeChanges implements ElementInterface, RendererAwareInterface, DataAwareInterface
{
    use RendererAwareTrait, DataAwareTrait;

    /**
     * @return string
     */
    public function getTitle()
    {
        return 'Review upgrade changes and fix possible customization conflicts';
    }

    /**
     * @return int
     */
    public function getOrder()
    {
        return 3;
    }

    /**
     * @param Upgrade $context
     *
     * @return bool
     */
    public function isRelevantTo(Upgrade $context)
    {
        return $context->getTargetPath();
    }

    /**
     * @param Upgrade $context
     *
     * @return string
     */
    public function getBody(Upgrade $context)
    {
        $customizations = $this->dataManager->getPotentiallyBrokenCustomizations($context);

        return $this->renderer->render('upgrade_changes', [
            'upgrade_steps' => $this->dataManager->getUpgradeSteps($context),
            'upgrade_to' => $context->getTargetVersion(),
            'upgrade_source' => $context->getTargetPath(),
            'modified_files' => $customizations['modified_files'],
            'deleted_files' => $customizations['deleted_files'],
        ]);
    }
}
