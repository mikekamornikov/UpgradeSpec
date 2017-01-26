<?php

namespace spec\Sugarcrm\UpgradeSpec\Element\Section;

use Sugarcrm\UpgradeSpec\Element\ElementInterface;
use Sugarcrm\UpgradeSpec\Element\Section\ReleaseNotes;
use PhpSpec\ObjectBehavior;

class ReleaseNotesSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(ReleaseNotes::class);
    }

    function it_is_spec_element()
    {
        $this->shouldHaveType(ElementInterface::class);
    }
}
