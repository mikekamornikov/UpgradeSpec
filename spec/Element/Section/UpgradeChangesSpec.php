<?php

namespace spec\Sugarcrm\UpgradeSpec\Element\Section;

use Sugarcrm\UpgradeSpec\Element\ElementInterface;
use Sugarcrm\UpgradeSpec\Element\Section\UpgradeChanges;
use PhpSpec\ObjectBehavior;

class UpgradeChangesSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(UpgradeChanges::class);
    }

    function it_is_spec_element()
    {
        $this->shouldHaveType(ElementInterface::class);
    }
}
