<?php

namespace spec\Sugarcrm\UpgradeSpec\Element;

use PhpSpec\Exception\Example\FailureException;
use Prophecy\Argument;
use Sugarcrm\UpgradeSpec\Data\Manager;
use Sugarcrm\UpgradeSpec\Element\ElementInterface;
use Sugarcrm\UpgradeSpec\Element\Provider;
use PhpSpec\ObjectBehavior;
use Sugarcrm\UpgradeSpec\Element\Section\ExistingCoreChanges;
use Sugarcrm\UpgradeSpec\Element\Section\HealthCheck;
use Sugarcrm\UpgradeSpec\Element\Section\ReleaseNotes;
use Sugarcrm\UpgradeSpec\Element\Section\UpgradeChanges;
use Sugarcrm\UpgradeSpec\Element\Section\UpgradeExecution;
use Sugarcrm\UpgradeSpec\Spec\Context;
use Sugarcrm\UpgradeSpec\Template\RendererInterface;

class ProviderSpec extends ObjectBehavior
{
    /**
     * @var Context
     */
    private $context;

    function let(ElementInterface $element1, ElementInterface $element2)
    {
        $this->context = new Context('7.6.1', '7.8.0.0', 'ULT');

        $element1->getOrder()->willReturn(2);
        $element2->getOrder()->willReturn(1);

        $element1->isRelevantTo($this->context)->willReturn(true);
        $element2->isRelevantTo($this->context)->willReturn(true);

        $this->beConstructedWith([$element1, $element2]);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Provider::class);
    }

    function it_gets_elements_in_correct_order(ElementInterface $element1, ElementInterface $element2)
    {
        $this->getSuitableElements($this->context)->shouldReturn([$element2, $element1]);
    }

    function it_gets_suitable_elements(ElementInterface $element1, ElementInterface $element2, ElementInterface $element3)
    {
        $element1->isRelevantTo($this->context)->willReturn(false);

        $element3->getOrder()->willReturn(3);
        $element3->isRelevantTo($this->context)->willReturn(true);

        $this->addElements([$element3]);
        $this->getSuitableElements($this->context)->shouldReturn([$element2, $element3,]);
    }
}
