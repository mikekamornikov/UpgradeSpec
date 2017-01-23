<?php

namespace Sugarcrm\UpgradeSpec\Template;

interface RendererInterface
{
    /**
     * Renders template.
     *
     * @param $name
     * @param $arguments
     */
    public function render($name, $arguments);
}
