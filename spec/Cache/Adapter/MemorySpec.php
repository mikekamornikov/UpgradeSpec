<?php

namespace spec\Sugarcrm\UpgradeSpec\Cache\Adapter;

use Sugarcrm\UpgradeSpec\Cache\Adapter\Memory;
use PhpSpec\ObjectBehavior;

class MemorySpec extends ObjectBehavior
{
    use SimpleCacheSpecTrait;

    function let()
    {
        $this->beConstructedWith($this->data);
    }

    function letGo()
    {
        $this->clear();
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Memory::class);
    }
}
