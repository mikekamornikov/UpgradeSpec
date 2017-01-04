<?php

namespace spec\Sugarcrm\UpgradeSpec\Command;

use Sugarcrm\UpgradeSpec\Command\SelfRollbackCommand;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SelfRollbackCommandSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(SelfRollbackCommand::class);
    }

    function it_has_a_name()
    {
        $this->getName()->shouldReturn('self:rollback');
    }
}
