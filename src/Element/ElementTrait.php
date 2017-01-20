<?php

namespace Sugarcrm\UpgradeSpec\Element;

use Sugarcrm\UpgradeSpec\Data\Manager;
use Sugarcrm\UpgradeSpec\Template\Renderer;

trait ElementTrait
{
    /**
     * @var TemplateRenderer
     */
    private $renderer;
    /**
     * @var Manager
     */
    private $dataManager;

    /**
     * Element constructor.
     * @param Renderer $renderer
     * @param Manager $dataManager
     */
    public function __construct(Renderer $renderer, Manager $dataManager)
    {
        $this->renderer = $renderer;
        $this->dataManager = $dataManager;
    }
}
