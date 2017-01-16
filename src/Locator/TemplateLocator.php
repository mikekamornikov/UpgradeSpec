<?php

namespace Sugarcrm\UpgradeSpec\Locator;

class TemplateLocator
{
    /**
     * @var string
     */
    private $path;

    /**
     * TemplateLocator constructor.
     * @param string $path
     */
    public function __construct($path)
    {
        $this->path = $path;
    }

    /**
     * @param $template
     * @return string
     */
    public function locate($template)
    {
        $templatePath = $this->path . '/' . $template;
        if (!file_exists($templatePath)) {
            throw new \InvalidArgumentException(sprintf('Template "%s" not found', $template));
        }

        return $templatePath;
    }
}
