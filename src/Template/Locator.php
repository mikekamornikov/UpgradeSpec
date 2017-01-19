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
        $format = getenv('DEFAULT_FORMAT');
        $templatePath = sprintf('%s/%s/%s.md.tpl', $this->templateFolder, $format, $name);
        if (!file_exists($templatePath)) {
            throw new \InvalidArgumentException(sprintf('Template "%s" not found', $name));
        }

        return $templatePath;
    }
}
