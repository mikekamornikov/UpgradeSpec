<?php

namespace spec\Sugarcrm\UpgradeSpec\Element\Section;

use Sugarcrm\UpgradeSpec\Element\ElementInterface;
use Sugarcrm\UpgradeSpec\Element\Section\ExistingCoreChanges;
use PhpSpec\ObjectBehavior;

class ExistingCoreChangesSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(ExistingCoreChanges::class);
    }

    function it_is_spec_element()
    {
        $this->shouldHaveType(ElementInterface::class);
    }
}
