<?php

namespace spec\Sugarcrm\UpgradeSpec\Renderer;

use Sugarcrm\UpgradeSpec\Locator\TemplateLocator;
use Sugarcrm\UpgradeSpec\Renderer\TemplateRenderer;
use PhpSpec\ObjectBehavior;

class TemplateRendererSpec extends ObjectBehavior
{
    function let(TemplateLocator $locator)
    {
        $this->beConstructedWith($locator);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(TemplateRenderer::class);
    }
}
