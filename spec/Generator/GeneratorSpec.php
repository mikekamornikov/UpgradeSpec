<?php

namespace spec\Sugarcrm\UpgradeSpec\Generator;

use Prophecy\Argument;
use Sugarcrm\UpgradeSpec\Generator\Configurator;
use Sugarcrm\UpgradeSpec\Generator\SpecElement\SpecElementInterface;
use Sugarcrm\UpgradeSpec\Generator\Generator;
use Sugarcrm\UpgradeSpec\Generator\GeneratorInterface;
use PhpSpec\ObjectBehavior;
use Sugarcrm\UpgradeSpec\Generator\SpecElementGenerator;

class GeneratorSpec extends ObjectBehavior
{
    function let(Configurator $configurator, SpecElementGenerator $specElementGenerator, SpecElementInterface $step1, SpecElementInterface $step2)
    {
        $step1->getTitle()->willReturn('step1 title');
        $step1->getBody()->willReturn('step1 body');
        $step1->getOrder()->willReturn(1);
        $step1->isRelevantTo(Argument::cetera())->willReturn(true);

        $step2->getTitle()->willReturn('step2 title');
        $step2->getBody()->willReturn('step2 body');
        $step2->getOrder()->willReturn(2);
        $step2->isRelevantTo(Argument::cetera())->willReturn(true);

        $configurator->getElements(Argument::cetera())->willReturn([$step1, $step2]);

        $specElementGenerator->generate($step1)->willReturn('step1');
        $specElementGenerator->generate($step2)->willReturn('step2');

        $this->beConstructedWith($configurator, $specElementGenerator);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Generator::class);
    }

    function it_generates_uprade_spec()
    {
        $spec = 'step1' . PHP_EOL . PHP_EOL . 'step2';
        $this->generate('/path/to/sugarcrm/build', 'new_version')->shouldReturn($spec);
    }

    function it_executes_all_configured_steps(SpecElementGenerator $specElementGenerator, SpecElementInterface $step1, SpecElementInterface $step2)
    {
        $specElementGenerator->generate($step1)->shouldBeCalled();
        $specElementGenerator->generate($step2)->shouldBeCalled();

        $this->generate('/path/to/sugarcrm/build', 'new_version');
    }
}
