<?php

namespace spec\Sugarcrm\UpgradeSpec\Template;

use PhpSpec\ObjectBehavior;
use Sugarcrm\UpgradeSpec\Template\Locator;

class LocatorSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('/path/to/templates');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Locator::class);
    }
}
