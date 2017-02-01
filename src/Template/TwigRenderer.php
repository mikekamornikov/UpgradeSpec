<?php

namespace Sugarcrm\UpgradeSpec\Template;

use Twig_Environment;
use Twig_LoaderInterface;

class TwigRenderer implements RendererInterface
{
    /**
     * @var Twig_Environment
     */
    private $engine;

    /**
     * TwigRenderer constructor.
     *
     * @param Twig_LoaderInterface $loader
     * @param bool                 $debug
     */
    public function __construct(Twig_LoaderInterface $loader, $debug = false)
    {
        $this->engine = new Twig_Environment($loader, ['debug' => $debug]);
    }

    /**
     * @param $name
     * @param $arguments
     *
     * @return string
     */
    public function render($name, $arguments)
    {
        $templatePath = sprintf('%s.twig', $name);

        return $this->engine->load($templatePath)->render($arguments);
    }
}
