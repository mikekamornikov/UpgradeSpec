<?php

namespace Sugarcrm\UpgradeSpec\Generator;

use Sugarcrm\UpgradeSpec\Formatter\FormatterInterface;
use Sugarcrm\UpgradeSpec\Generator\SpecElement\SpecElementInterface;

class SpecElementGenerator
{
    /**
     * @var FormatterInterface
     */
    private $formatter;

    public function __construct(FormatterInterface $formatter)
    {
        $this->formatter = $formatter;
    }


    public function generate(SpecElementInterface $element)
    {
        return $this->formatter->asTitle($element->getTitle(), 2)
            . $this->formatter->getDelimiter()
            . $this->formatter->asBody($element->getBody());
    }
}
