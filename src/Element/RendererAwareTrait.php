<?php

namespace Sugarcrm\UpgradeSpec\Element;

use Sugarcrm\UpgradeSpec\Template\RendererInterface;

trait RendererAwareTrait
{
    /**
     * @var Manager
     */
    private $renderer;

    /**
     * @param RendererInterface $renderer
     */
    public function setRenderer(RendererInterface $renderer)
    {
        $this->renderer = $renderer;
    }
}
