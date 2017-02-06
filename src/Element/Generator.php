<?php

namespace Sugarcrm\UpgradeSpec\Element;

use Sugarcrm\UpgradeSpec\Formatter\FormatterInterface;
use Sugarcrm\UpgradeSpec\Context\Upgrade;

class Generator
{
    /**
     * @var FormatterInterface
     */
    private $formatter;

    /**
     * Generator constructor.
     *
     * @param FormatterInterface $formatter
     */
    public function __construct(FormatterInterface $formatter)
    {
        $this->formatter = $formatter;
    }

    /**
     * @param ElementInterface $element
     * @param Upgrade          $context
     *
     * @return string
     */
    public function generate(ElementInterface $element, Upgrade $context)
    {
        return $this->formatter->asTitle($element->getTitle(), 2)
            . $this->formatter->getDelimiter()
            . $this->formatter->asBody($element->getBody($context));
    }
}
