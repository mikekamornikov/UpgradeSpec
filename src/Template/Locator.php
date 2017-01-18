<?php

namespace Sugarcrm\UpgradeSpec\Template;

class Locator
{
    /**
     * @var string
     */
    private $templateFolder;

    /**
     * TemplateLocator constructor.
     * @param string $templateFolder
     */
    public function __construct($templateFolder)
    {
        $this->templateFolder = $templateFolder;
    }

    /**
     * @param $name
     * @return string
     */
    public function locate($name)
    {
        $templatePath = sprintf('%s/%s.tpl', $this->templateFolder, $name);
        if (!file_exists($templatePath)) {
            throw new \InvalidArgumentException(sprintf('Template "%s" not found', $name));
        }

        return $templatePath;
    }
}
