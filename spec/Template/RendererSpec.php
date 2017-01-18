<?php

namespace spec\Sugarcrm\UpgradeSpec\Renderer;

use PhpSpec\ObjectBehavior;
use Sugarcrm\UpgradeSpec\Template\Locator;
use Sugarcrm\UpgradeSpec\Template\Renderer;

class RendererSpec extends ObjectBehavior
{
    function let(Locator $locator)
    {
        $this->beConstructedWith($locator);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Renderer::class);
    }
}
