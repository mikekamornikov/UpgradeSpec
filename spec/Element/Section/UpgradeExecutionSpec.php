<?php

namespace spec\Sugarcrm\UpgradeSpec\Element\Section;

use Sugarcrm\UpgradeSpec\Element\ElementInterface;
use Sugarcrm\UpgradeSpec\Element\Section\UpgradeExecution;
use PhpSpec\ObjectBehavior;

class UpgradeExecutionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(UpgradeExecution::class);
    }

    function it_is_spec_element()
    {
        $this->shouldHaveType(ElementInterface::class);
    }
}
