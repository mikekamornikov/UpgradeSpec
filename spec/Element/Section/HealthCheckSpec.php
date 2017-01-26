<?php

namespace spec\Sugarcrm\UpgradeSpec\Element\Section;

use Sugarcrm\UpgradeSpec\Element\ElementInterface;
use Sugarcrm\UpgradeSpec\Element\Section\HealthCheck;
use PhpSpec\ObjectBehavior;

class HealthCheckSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(HealthCheck::class);
    }

    function it_is_spec_element()
    {
        $this->shouldHaveType(ElementInterface::class);
    }
}
