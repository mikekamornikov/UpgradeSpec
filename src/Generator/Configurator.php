<?php

namespace Sugarcrm\UpgradeSpec\Generator;

use Sugarcrm\UpgradeSpec\Generator\SpecElement\SpecElementInterface;

class Configurator
{
    private $elements;

    /**
     * Configurator constructor.
     * @param $elements
     */
    public function __construct($elements)
    {
        $this->elements = $elements;
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
        $elements = array_filter($this->elements, function (SpecElementInterface $element) use ($newVersion) {
            return $element->isRelevantTo($newVersion);
        });

        usort($elements, function (SpecElementInterface $a, SpecElementInterface $b) {
            return $a->getOrder() > $b->getOrder() ? 1 : ($a->getOrder() < $b->getOrder() ? -1 : 0);
        });

        return $elements;
    }
}
