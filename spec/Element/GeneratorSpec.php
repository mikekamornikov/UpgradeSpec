<?php

namespace spec\Sugarcrm\UpgradeSpec\Element;

use Prophecy\Argument;
use Sugarcrm\UpgradeSpec\Context\Target;
use Sugarcrm\UpgradeSpec\Context\TestBuild;
use Sugarcrm\UpgradeSpec\Element\ElementInterface;
use Sugarcrm\UpgradeSpec\Element\Generator;
use PhpSpec\ObjectBehavior;
use Sugarcrm\UpgradeSpec\Formatter\MarkdownFormatter;
use Sugarcrm\UpgradeSpec\Context\Upgrade;
use Sugarcrm\UpgradeSpec\Version\Version;

class GeneratorSpec extends ObjectBehavior
{
    /**
     * @var Upgrade
     */
    private $context;

    function let()
    {
        $this->context = new Upgrade(
            new TestBuild(new Version('7.6.1'), 'ULT', '/path/to/build'),
            new Target(new Version('7.8.0.0'), 'ULT', '/path/to/upgrade/packages')
        );

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

        $this->generate($element, $this->context)->shouldReturn('## Title' . PHP_EOL . PHP_EOL . 'body');
    }
}
