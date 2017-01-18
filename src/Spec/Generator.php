<?php

namespace Sugarcrm\UpgradeSpec\Spec;

use Sugarcrm\UpgradeSpec\Element\Provider;
use Sugarcrm\UpgradeSpec\Element\Generator as ElementGenerator;
use Sugarcrm\UpgradeSpec\Formatter\FormatterInterface;
use Sugarcrm\UpgradeSpec\Spec\Exception\GeneratorException;

class Generator
{
    /**
     * @var ElementProvider
     */
    private $elementProvider;

    /**
     * @var ElementGenerator
     */
    private $elementGenerator;

    /**
     * @var FormatterInterface
     */
    private $formatter;

    /**
     * SpecGenerator constructor.
     * @param Provider $elementProvider
     * @param ElementGenerator $elementGenerator
     * @param FormatterInterface $formatter
     */
    public function __construct(Provider $elementProvider,
        ElementGenerator $elementGenerator,
        FormatterInterface $formatter
    ) {
        $this->elementGenerator = $elementGenerator;
        $this->formatter = $formatter;
        $this->elementProvider = $elementProvider;
    }

    /**
     * @param $buildVersion
     * @param $upgradeTo
     * @return string
     * @throws GeneratorException
     */
    public function generate($buildVersion, $upgradeTo)
    {
        try {
            $delimiter = $this->formatter->getDelimiter();
            $elements = $this->elementProvider->getElements($buildVersion, $upgradeTo);

            $title = $this->formatter->asTitle(sprintf('%s -> %s upgrade', $buildVersion, $upgradeTo)) . $delimiter;

            return $title . implode($delimiter, array_map(
                function ($element) {
                    return $this->elementGenerator->generate($element);
                },
                $elements
            ));
        } catch (\Exception $e) {
            throw new GeneratorException($e->getMessage(), $e->getCode(), $e);
        }
    }
}
