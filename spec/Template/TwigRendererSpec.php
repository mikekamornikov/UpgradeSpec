<?php

namespace spec\Sugarcrm\UpgradeSpec\Template;

use PhpSpec\ObjectBehavior;
use Sugarcrm\UpgradeSpec\Template\TwigRenderer;
use Twig_Loader_Array;

class TwigRendererSpec extends ObjectBehavior
{
    function let()
    {
        $loader = new Twig_Loader_Array(['test.twig' => 'Hello {{ name }}!']);

        $this->beConstructedWith($loader);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(TwigRenderer::class);
    }

    function it_renders_twig_template()
    {
        $this->render('test', ['name' => 'Mike'])->shouldReturn('Hello Mike!');
    }
}
