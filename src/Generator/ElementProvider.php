<?php

namespace Sugarcrm\UpgradeSpec\Generator;

use Sugarcrm\UpgradeSpec\Generator\Element\ElementInterface;
use Sugarcrm\UpgradeSpec\Renderer\TemplateRenderer;

class ElementProvider
{
    private $elements;

    /**
     * Configurator constructor.
     * @param $elements
     * @param TemplateRenderer $templateRenderer
     */
    public function __construct($elements, TemplateRenderer $templateRenderer)
    {
        $this->elements = array_map(function ($element) use ($templateRenderer) {
            return new $element($templateRenderer);
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
