<?php

namespace spec\Sugarcrm\UpgradeSpec\Data;

use Prophecy\Argument;
use Sugarcrm\UpgradeSpec\Data\Provider\DocProviderInterface;
use Sugarcrm\UpgradeSpec\Data\Provider\Memory;
use Sugarcrm\UpgradeSpec\Data\Provider\PackageDataProviderInterface;
use Sugarcrm\UpgradeSpec\Data\Provider\ProviderInterface;
use Sugarcrm\UpgradeSpec\Data\ProviderChain;
use PhpSpec\ObjectBehavior;

class ProviderChainSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(ProviderChain::class);
    }

    function it_expects_array_or_instance_of_traversable(ProviderInterface $p1, ProviderInterface $p2)
    {
        $this->beConstructedWith('aaa');
        $this->shouldThrow(\InvalidArgumentException::class)->duringInstantiation();

        $this->beConstructedWith(111);
        $this->shouldThrow(\InvalidArgumentException::class)->duringInstantiation();

        $this->beConstructedWith([]);
        $this->shouldNotThrow(\InvalidArgumentException::class)->duringInstantiation();

        $this->beConstructedWith(new \ArrayIterator([]));
        $this->shouldNotThrow(\InvalidArgumentException::class)->duringInstantiation();
    }

    function it_expects_providers(ProviderInterface $p1, ProviderInterface $p2)
    {
        $p1 = $p1->getWrappedObject();
        $p2 = $p2->getWrappedObject();

        $this->beConstructedWith([new \stdClass()]);
        $this->shouldThrow(\InvalidArgumentException::class)->duringInstantiation();

        $this->beConstructedWith([$p1, $p2]);
        $this->shouldNotThrow(\InvalidArgumentException::class)->duringInstantiation();

        $this->beConstructedWith(new \ArrayIterator([$p1, $p2]));
        $this->shouldNotThrow(\InvalidArgumentException::class)->duringInstantiation();

        $g = function () use ($p1, $p2) {
            yield $p1;
            yield $p2;
        };
        $this->beConstructedWith($g());
        $this->shouldNotThrow(\InvalidArgumentException::class)->duringInstantiation();
    }

    function it_proxies_calls_to_given_providers()
    {
        $versions = ['7.7.2', '7.8.0.0'];
        $this->beConstructedWith([new Memory(['ult_versions' => $versions])]);
        $this->getVersions('ULT')->shouldReturn($versions);
    }

    function it_throws_exception_on_invalid_call(ProviderInterface $p1)
    {
        $this->beConstructedWith([$p1->getWrappedObject()]);;
        $this->shouldThrow(\RuntimeException::class)->during('non_existent_method', []);
    }
}
