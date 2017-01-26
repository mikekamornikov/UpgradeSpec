<?php

namespace spec\Sugarcrm\UpgradeSpec\Spec;

use Sugarcrm\UpgradeSpec\Spec\Context;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ContextSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('7.6.1', '7.8.0.0', 'ULT');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Context::class);
    }

    function it_stores_build_version()
    {
        $this->getBuildVersion()->shouldReturn('7.6.1');
    }

    function it_stores_upgrade_version()
    {
        $this->getUpgradeVersion()->shouldReturn('7.8.0.0');
    }

    function it_stores_flav()
    {
        $this->getFlav()->shouldReturn('ULT');
    }

    function it_can_be_used_as_a_string()
    {
        $this->__toString()->shouldReturn('7.6.1 -> 7.8.0.0 (ULT)');
    }

    function it_can_be_used_as_filename()
    {
        $this->asFilename()->shouldReturn('upgrade_7.6.1_to_7.8.0.0_ULT');
    }
}
