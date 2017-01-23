<?php

namespace Sugarcrm\UpgradeSpec\Element;

use Sugarcrm\UpgradeSpec\Data\Manager;
use Sugarcrm\UpgradeSpec\Template\RendererInterface;

trait ElementTrait
{
    /**
     * @var RendererInterface
     */
    private $renderer;

    /**
     * @var Manager
     */
    private $dataManager;

    /**
     * Element constructor.
     * @param RendererInterface $renderer
     * @param Manager $dataManager
     */
    public function __construct(RendererInterface $renderer, Manager $dataManager)
    {
        $this->renderer = $renderer;
        $this->dataManager = $dataManager;
    }
}
