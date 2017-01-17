<?php

namespace spec\Sugarcrm\UpgradeSpec\Generator;

use Prophecy\Argument;
use Sugarcrm\UpgradeSpec\Formatter\FormatterInterface;
use Sugarcrm\UpgradeSpec\Generator\Element\ElementInterface;
use Sugarcrm\UpgradeSpec\Generator\ElementGenerator;
use Sugarcrm\UpgradeSpec\Generator\ElementProvider;
use Sugarcrm\UpgradeSpec\Generator\SpecGenerator;
use Sugarcrm\UpgradeSpec\Generator\GeneratorInterface;
use PhpSpec\ObjectBehavior;

class SpecGeneratorSpec extends ObjectBehavior
{
    function let(ElementProvider $elementProvider,
        ElementGenerator $specElementGenerator,
        ElementInterface $step1,
        ElementInterface $step2,
        FormatterInterface $formatter
    ) {
        $step1->getTitle()->willReturn('step1 title');
        $step1->getBody()->willReturn('step1 body');
        $step1->getOrder()->willReturn(1);
        $step1->isRelevantTo(Argument::cetera())->willReturn(true);

        $step2->getTitle()->willReturn('step2 title');
        $step2->getBody()->willReturn('step2 body');
        $step2->getOrder()->willReturn(2);
        $step2->isRelevantTo(Argument::cetera())->willReturn(true);

        $elementProvider->getElements(Argument::cetera())->willReturn([$step1, $step2]);

        $specElementGenerator->generate($step1)->willReturn('step1');
        $specElementGenerator->generate($step2)->willReturn('step2');

        $formatter->asTitle(Argument::any())->willReturn('spec_title');
        $formatter->getDelimiter()->willReturn('delimiter');

        $this->beConstructedWith($elementProvider, $specElementGenerator, $formatter);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(SpecGenerator::class);
    }

    function it_generates_uprade_spec()
    {
        $spec = 'spec_title' . 'delimiter' . 'step1' . 'delimiter' . 'step2';
        $this->generate('/path/to/sugarcrm/build', 'new_version')->shouldReturn($spec);
    }

    function it_executes_all_configured_steps(ElementGenerator $specElementGenerator, ElementInterface $step1, ElementInterface $step2)
    {
        $specElementGenerator->generate($step1)->shouldBeCalled();
        $specElementGenerator->generate($step2)->shouldBeCalled();

        $this->generate('/path/to/sugarcrm/build', 'new_version');
    }
}
