<?php

namespace spec\Sugarcrm\UpgradeSpec\Command;

use Sugarcrm\UpgradeSpec\Command\GenerateSpecCommand;
use PhpSpec\ObjectBehavior;

class GenerateSpecCommandSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(GenerateSpecCommand::class);
    }
}
