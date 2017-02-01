<?php

namespace Sugarcrm\UpgradeSpec\Template;

trait RendererAwareTrait
{
    /**
     * @var RendererInterface
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
