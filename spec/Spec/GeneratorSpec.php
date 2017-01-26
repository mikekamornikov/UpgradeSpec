<?php

namespace spec\Sugarcrm\UpgradeSpec\Spec;

use Prophecy\Argument;
use Sugarcrm\UpgradeSpec\Element\ElementInterface;
use Sugarcrm\UpgradeSpec\Element\Provider;
use Sugarcrm\UpgradeSpec\Element\Generator as ElementGenerator;
use Sugarcrm\UpgradeSpec\Formatter\FormatterInterface;
use PhpSpec\ObjectBehavior;
use Sugarcrm\UpgradeSpec\Spec\Context;
use Sugarcrm\UpgradeSpec\Spec\Generator;

class GeneratorSpec extends ObjectBehavior
{
    /**
     * @var Context
     */
    private $context;

    function let(Provider $elementProvider,
        ElementGenerator $specElementGenerator,
        ElementInterface $step1,
        ElementInterface $step2,
        FormatterInterface $formatter
    ) {
        $this->context = new Context('7.6.1', '7.8.0.0', 'ULT');

        $step1->getTitle()->willReturn('section1 title');
        $step1->getBody()->willReturn('section1 body');

        $step2->getTitle()->willReturn('section2 title');
        $step2->getBody()->willReturn('section2 body');

        $elementProvider->getElements($this->context)->willReturn([$step1, $step2]);

        $specElementGenerator->generate($step1, $this->context)->willReturn('section1 full');
        $specElementGenerator->generate($step2, $this->context)->willReturn('section2 full');

        $formatter->asTitle(Argument::any())->willReturn('spec_title');
        $formatter->asBody(Argument::any())->willReturn('spec_body');
        $formatter->getDelimiter()->willReturn('delimiter');

        $this->beConstructedWith($elementProvider, $specElementGenerator, $formatter);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Generator::class);
    }

    function it_generates_uprade_spec()
    {
        $spec = 'spec_title' . 'delimiter' . 'section1 full' . 'delimiter' . 'section2 full';

        $this->generate($this->context)->shouldReturn($spec);
    }

    function it_executes_all_configured_steps(ElementGenerator $specElementGenerator, ElementInterface $step1, ElementInterface $step2)
    {
        $specElementGenerator->generate($step1, $this->context)->shouldBeCalled();
        $specElementGenerator->generate($step2, $this->context)->shouldBeCalled();

        $this->generate($this->context);
    }
}
