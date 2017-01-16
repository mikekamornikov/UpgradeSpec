<?php

namespace spec\Sugarcrm\UpgradeSpec\Formatter;

use Sugarcrm\UpgradeSpec\Formatter\MarkdownFormatter;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MarkdownFormatterSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(MarkdownFormatter::class);
    }

    function it_formats_title()
    {
        $this->asTitle('text')->shouldReturn('# Text');
        $this->asTitle('text', 1)->shouldReturn('# Text');
        $this->asTitle('text', 2)->shouldReturn('## Text');
        $this->asTitle('Text', 2)->shouldReturn('## Text');
        $this->asTitle('text', 3)->shouldReturn('### Text');
    }

    function it_formats_body()
    {
        $this->asBody('Text')->shouldReturn('Text');
    }

    function it_uses_2_spaces_as_delimiter()
    {
        $this->getDelimiter()->shouldReturn(PHP_EOL . PHP_EOL);
    }
}
