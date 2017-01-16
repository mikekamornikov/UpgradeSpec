<?php

namespace Sugarcrm\UpgradeSpec\Generator;

use Sugarcrm\UpgradeSpec\Formatter\FormatterInterface;
use Sugarcrm\UpgradeSpec\Generator\Exception\GeneratorException;

class Generator
{
    /**
     * @var Configurator
     */
    private $configurator;

    /**
     * @var SpecElementGenerator
     */
    private $elementGenerator;

    /**
     * @var FormatterInterface
     */
    private $formatter;

    /**
     * SpecGenerator constructor.
     * @param Configurator $configurator
     * @param SpecElementGenerator $elementGenerator
     */
    public function __construct(Configurator $configurator,
        SpecElementGenerator $elementGenerator,
        FormatterInterface $formatter
    ) {
        $this->configurator = $configurator;
        $this->elementGenerator = $elementGenerator;
        $this->formatter = $formatter;
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
            $elements = $this->configurator->getElements($buildVersion, $upgradeTo);

            $title = $this->formatter->asTitle(sprintf('%s -> %s upgrade', $buildVersion, $upgradeTo));

            return $title . implode($this->formatter->getDelimiter(), array_map(
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
