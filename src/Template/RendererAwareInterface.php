<?php

namespace Sugarcrm\UpgradeSpec\Template;

interface RendererAwareInterface
{
    public function setRenderer(RendererInterface $renderer);
}
