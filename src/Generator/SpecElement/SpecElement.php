<?php

namespace Sugarcrm\UpgradeSpec\Generator\SpecElement;

use Sugarcrm\UpgradeSpec\Locator\TemplateLocator;

class SpecElement
{
    /**
     * @var TemplateLocator
     */
    private $locator;

    public function __construct(TemplateLocator $locator)
    {
        $this->locator = $locator;
    }

    /**
     * @param array $args
     * @return string
     */
    protected function render($args = [])
    {
        $className = explode('\\', get_class($this));
        $templateName = array_pop($className);

        try {
            $template = file_get_contents($this->locator->locate($templateName));

            if (!$args) {
                return $template;
            }

            $variables = array_map(function ($arg) {
                return '{{' . $arg . '}}';
            }, array_keys($args));

            return str_replace($variables, array_values($args), $template);
        } catch (\Exception $e) {
            return '';
        }
    }
}
