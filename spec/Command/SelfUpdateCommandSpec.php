<?php

namespace spec\Sugarcrm\UpgradeSpec\Command;

use Sugarcrm\UpgradeSpec\Command\SelfUpdateCommand;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SelfUpdateCommandSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(SelfUpdateCommand::class);
    }

    function it_has_a_name()
    {
        $this->getName()->shouldReturn('self:update');
    }
}
