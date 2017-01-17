<?php

namespace Sugarcrm\UpgradeSpec\Generator\Element;

use Sugarcrm\UpgradeSpec\Renderer\TemplateRenderer;

trait ElementTrait
{
    /**
     * @var TemplateRenderer
     */
    private $renderer;

    public function __construct(TemplateRenderer $renderer)
    {
        $this->renderer = $renderer;
    }
}
