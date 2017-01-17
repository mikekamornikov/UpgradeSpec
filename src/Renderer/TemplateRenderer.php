<?php

namespace Sugarcrm\UpgradeSpec\Renderer;

use Sugarcrm\UpgradeSpec\Locator\TemplateLocator;

class TemplateRenderer
{
    /**
     * @var FileLocatorInterface
     */
    private $templateLocator;

    public function __construct(TemplateLocator $templateLocator)
    {
        $this->templateLocator = $templateLocator;
    }

    public function render($name, $arguments)
    {
        try {
            $template = trim(file_get_contents($this->templateLocator->locate($name)));

            if (!$arguments) {
                return $template;
            }

            $variables = array_map(function ($argument) {
                return '{{' . $argument . '}}';
            }, array_keys($arguments));

            return str_replace($variables, array_values($arguments), $template);
        } catch (\Exception $e) {
            return '';
        }
    }
}
