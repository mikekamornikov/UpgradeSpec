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
     * @param $buildVersion
     * @param $upgradeTo
     *
     * @return string
     */
    public function generate(ElementInterface $element, $buildVersion, $upgradeTo)
    {
        return $this->formatter->asTitle($element->getTitle(), 2)
            . $this->formatter->getDelimiter()
            . $this->formatter->asBody($element->getBody($buildVersion, $upgradeTo));
    }
}
