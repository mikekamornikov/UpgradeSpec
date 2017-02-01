<?php

namespace Sugarcrm\UpgradeSpec\Element;

use Sugarcrm\UpgradeSpec\Spec\Context;

class Provider
{
    /**
     * @var array
     */
    private $specElements = [];

    /**
     * Provider constructor.
     *
     * @param array $specElements
     */
    public function __construct($specElements = [])
    {
        $this->addElements($specElements);
    }

    /**
     * Adds elements to provider.
     *
     * @param mixed $elements
     */
    public function addElements($elements)
    {
        if (!is_array($elements) && !$elements instanceof \Traversable) {
            throw new \InvalidArgumentException(sprintf('Argument is not traversable: %s', $elements));
        }

        $elements = is_array($elements) ? $elements : iterator_to_array($elements);

        foreach ($elements as $element) {
            if (!is_a($element, ElementInterface::class)) {
                throw new \InvalidArgumentException('Provider expects ElementInterface[]');
            }
        }

        $this->specElements = array_merge($this->specElements, $elements);
    }

    /**
     * @param Context $context
     *
     * @return array
     */
    public function getSuitableElements(Context $context)
    {
        $elements = array_filter($this->specElements, function (ElementInterface $element) use ($context) {
            return $element->isRelevantTo($context);
        });

        if (!$elements) {
            throw new \DomainException(sprintf('No special steps required to upgrade from "%s" to "%s" (%s))',
                $context->getBuildVersion(),
                $context->getUpgradeVersion(),
                $context->getFlav()
            ));
        }

        // sort elements (ASC)
        usort($elements, function (ElementInterface $a, ElementInterface $b) {
            return $a->getOrder() > $b->getOrder() ? 1 : ($a->getOrder() < $b->getOrder() ? -1 : 0);
        });

        return $elements;
    }
}
