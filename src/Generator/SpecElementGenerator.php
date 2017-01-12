<?php

namespace Sugarcrm\UpgradeSpec\Generator;

use Sugarcrm\UpgradeSpec\Generator\SpecElement\SpecElementInterface;

class SpecElementGenerator
{
    public function generate(SpecElementInterface $element)
    {
        return $element->getTitle() . PHP_EOL . $element->getBody();
    }
}
