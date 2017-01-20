<?php

namespace Sugarcrm\UpgradeSpec\Element;

use Sugarcrm\UpgradeSpec\Data\Manager;
use Sugarcrm\UpgradeSpec\Template\Renderer;

class Provider
{
    private $elements;

    /**
     * Configurator constructor.
     * @param $elements
     * @param Renderer $templateRenderer
     * @param Manager $dataManager
     */
    public function __construct($elements, Renderer $templateRenderer, Manager $dataManager)
    {
        $this->elements = array_map(function ($element) use ($templateRenderer, $dataManager) {
            return new $element($templateRenderer, $dataManager);
        }, $elements);
    }

    /**
     * @param $buildVersion
     * @param $upgradeTo
     * @return array
     */
    public function getElements($buildVersion, $upgradeTo)
    {
        $elements = $this->getSuitableElements($buildVersion, $upgradeTo);

        if (!$elements) {
            throw new \DomainException(sprintf('No special steps required to upgrade from "%s" to "%s")',
                $buildVersion,
                $upgradeTo
            ));
        }

        return $elements;
    }

    /**
     * @param $oldVersion
     * @param $newVersion
     * @return array
     */
    private function getSuitableElements($oldVersion, $newVersion)
    {
        $elements = array_filter($this->elements, function (ElementInterface $element) use ($oldVersion, $newVersion) {
            return $element->isRelevantTo($oldVersion, $newVersion);
        });

        usort($elements, function (ElementInterface $a, ElementInterface $b) {
            return $a->getOrder() > $b->getOrder() ? 1 : ($a->getOrder() < $b->getOrder() ? -1 : 0);
        });

        return $elements;
    }
}
