<?php

namespace Sugarcrm\UpgradeSpec\Generator\Element;

use Sugarcrm\UpgradeSpec\Template\Renderer;

trait ElementTrait
{
    /**
     * @var TemplateRenderer
     */
    private $renderer;

    public function __construct(Renderer $renderer)
    {
        $this->renderer = $renderer;
    }
}
