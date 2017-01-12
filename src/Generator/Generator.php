<?php

namespace Sugarcrm\UpgradeSpec\Generator;

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
     * SpecGenerator constructor.
     * @param Configurator $configurator
     * @param SpecElementGenerator $elementGenerator
     */
    public function __construct(Configurator $configurator, SpecElementGenerator $elementGenerator)
    {
        $this->configurator = $configurator;
        $this->elementGenerator = $elementGenerator;
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
            $delimiter = PHP_EOL . PHP_EOL;
            $elements = $this->configurator->getElements($buildVersion, $upgradeTo);

            return implode($delimiter, array_map(
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
