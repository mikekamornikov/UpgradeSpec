<?php

namespace Sugarcrm\UpgradeSpec\Generator;

use Sugarcrm\UpgradeSpec\Generator\SpecElement\CoreChanges;
use Sugarcrm\UpgradeSpec\Generator\SpecElement\ReleaseNotes;
use Sugarcrm\UpgradeSpec\Generator\SpecElement\SpecElementInterface;

class Configurator
{
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
        $isRelevant = function (SpecElementInterface $element) use ($newVersion) {
            return $element->isRelevantTo($newVersion);
        };

        $elements = array_filter([
            new CoreChanges(),
            new ReleaseNotes()
        ], $isRelevant);

        $comparator = function (SpecElementInterface $a, SpecElementInterface $b) {
            return $a->getOrder() > $b->getOrder() ? 1 : ($a->getOrder() < $b->getOrder() ? -1 : 0);
        };

        usort($elements, $comparator);

        return $elements;
    }
}
