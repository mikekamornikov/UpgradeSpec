<?php

namespace Sugarcrm\UpgradeSpec\Element;

use Sugarcrm\UpgradeSpec\Formatter\FormatterInterface;

class Generator
{
    /**
     * @var FormatterInterface
     */
    private $formatter;

    public function __construct(FormatterInterface $formatter)
    {
        $this->formatter = $formatter;
    }

    /**
     * @param ElementInterface $element
     * @return string
     */
    public function generate(ElementInterface $element)
    {
        return $this->formatter->asTitle($element->getTitle(), 2)
            . $this->formatter->getDelimiter()
            . $this->formatter->asBody($element->getBody());
    }
}
