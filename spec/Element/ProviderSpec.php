<?php

namespace spec\Sugarcrm\UpgradeSpec\Element;

use PhpSpec\Exception\Example\FailureException;
use Sugarcrm\UpgradeSpec\Data\Manager;
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
    function let(RendererInterface $templateRenderer, Manager $dataManager)
    {
        $this->beConstructedWith($templateRenderer, $dataManager);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Provider::class);
    }

    function it_gets_suitable_elements_in_correct_order()
    {
        $this->getElements(new Context('7.6.1', '7.8.0.0', 'ULT'))->shouldReturnTypes([
            ReleaseNotes::class,
            ExistingCoreChanges::class,
            UpgradeChanges::class,
            HealthCheck::class,
            UpgradeExecution::class
        ]);

        $this->getElements(new Context('6.5', '6.7', 'ULT'))->shouldReturnTypes([
            ReleaseNotes::class,
            ExistingCoreChanges::class,
            UpgradeChanges::class,
            UpgradeExecution::class
        ]);
    }

    public function getMatchers()
    {
        return [
            'returnTypes' => function ($subject, $types) {
                $subjectTypes = array_map(function ($object) {
                    return get_class($object);
                }, $subject);

                if (array_diff($subjectTypes, $types)) {
                    throw new FailureException(sprintf(
                        "Expected types are: %s\ngot: %s",
                        var_export($types, true), var_export($subjectTypes, true)
                    ));
                }

                return true;
            },
        ];
    }
}
