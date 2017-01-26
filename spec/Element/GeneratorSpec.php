<?php

namespace spec\Sugarcrm\UpgradeSpec\Element;

use Prophecy\Argument;
use Sugarcrm\UpgradeSpec\Element\ElementInterface;
use Sugarcrm\UpgradeSpec\Element\Generator;
use PhpSpec\ObjectBehavior;
use Sugarcrm\UpgradeSpec\Formatter\MarkdownFormatter;
use Sugarcrm\UpgradeSpec\Spec\Context;

class GeneratorSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(new MarkdownFormatter());
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Generator::class);
    }

    function it_generates_spec_section(ElementInterface $element)
    {
        $element->getTitle()->willReturn('title');
        $element->getBody(Argument::cetera())->willReturn('body');
        $context = new Context('7.6.1', '7.8.0.0', 'ULT');

        $this->generate($element, $context)->shouldReturn('## Title' . PHP_EOL . PHP_EOL . 'body');
    }
}
