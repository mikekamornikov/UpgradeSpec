<?php

namespace Sugarcrm\UpgradeSpec\Element;

use Sugarcrm\UpgradeSpec\Template\RendererInterface;

interface RendererAwareInterface
{
    public function setRenderer(RendererInterface $renderer);
}
