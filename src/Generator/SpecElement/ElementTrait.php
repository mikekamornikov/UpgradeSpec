<?php

namespace Sugarcrm\UpgradeSpec\Generator\SpecElement;

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
