<?php

namespace spec\Sugarcrm\UpgradeSpec\Template;

use Sugarcrm\UpgradeSpec\Locator\TemplateLocator;
use PhpSpec\ObjectBehavior;

class TemplateLocatorSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(TemplateLocator::class);
    }
}
