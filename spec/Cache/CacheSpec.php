<?php

namespace spec\Sugarcrm\UpgradeSpec\Cache;

use Psr\SimpleCache\CacheInterface;
use Sugarcrm\UpgradeSpec\Cache\Adapter\Memory;
use Sugarcrm\UpgradeSpec\Cache\Cache;
use PhpSpec\ObjectBehavior;

class CacheSpec extends ObjectBehavior
{
    /**
     * @var CacheInterface
     */
    private $adapter;

    function let()
    {
        $this->adapter = new Memory([
            'a' => 'aaa',
            'b' => null,
        ]);

        $this->beConstructedWith($this->adapter);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Cache::class);
    }

    function it_checks_if_cache_entry_exists()
    {
        $this->has('a')->shouldBe(true);
        $this->has('b')->shouldBe(true);
        $this->has('c')->shouldBe(false);
    }

    function it_returns_existing_value_by_key()
    {
        $this->get('a')->shouldReturn('aaa');
        $this->get('b')->shouldReturn(null);
        $this->get('c')->shouldReturn(null);
    }

    function it_returns_default_value_if_key_not_found()
    {
        $this->get('a', '111')->shouldReturn('aaa');
        $this->get('b', '111')->shouldReturn(null);
        $this->get('c', '111')->shouldReturn('111');
    }

    function it_preserves_type_of_cache_entry()
    {
        $this->get('c', '111')->shouldReturn('111');
        $this->get('c', 111)->shouldReturn(111);

        $this->set('d', null);
        $this->get('d')->shouldReturn(null);

        $this->set('d', 'string');
        $this->get('d')->shouldReturn('string');

        $this->set('d', false);
        $this->get('d')->shouldReturn(false);

        $this->set('d', true);
        $this->get('d')->shouldReturn(true);

        $this->set('d', 1.1);
        $this->get('d')->shouldReturn(1.1);

        $d = new \stdClass();
        $d->arr = ['a' => 'b'];

        $this->set('d', $d);
        $this->get('d')->shouldBeObject();
    }

    function it_can_get_several_cache_entries()
    {
        $this->get(['a', 'b', 'c'])->shouldYield(new \ArrayIterator(['a' => 'aaa', 'b' => null, 'c' => null]));
        $this->get(['a', 'b', 'c'], 111)->shouldYield(new \ArrayIterator(['a' => 'aaa', 'b' => null, 'c' => 111]));
    }

    function it_can_add_cache_entry()
    {
        $this->set('d', 111)->shouldBe(true);
        $this->get('d')->shouldReturn(111);
    }

    function it_can_add_cache_entry_with_ttl()
    {
        $this->set('d', 111, 3600)->shouldBe(true);
        $this->get('d')->shouldReturn(111);

        $this->set('d', 111, -1)->shouldBe(true);
        $this->get('d')->shouldReturn(null);

        $this->set('d', 111, \DateInterval::createFromDateString('-1 hour'))->shouldBe(true);
        $this->get('d')->shouldReturn(null);
    }

    function it_can_add_several_cache_entries()
    {
        $this->setMultiple(['a' => '111', 'd' => 222])->shouldBe(true);
        $this->get(['a', 'd'])->shouldYield(new \ArrayIterator(['a' => '111', 'd' => 222]));
    }

    function it_can_add_several_cache_entries_with_ttl()
    {
        $this->setMultiple(['a' => '111', 'd' => 222], 3600)->shouldBe(true);
        $this->get(['a', 'd'])->shouldYield(new \ArrayIterator(['a' => '111', 'd' => 222]));

        $this->setMultiple(['a' => '111', 'd' => 222], -1)->shouldBe(true);
        $this->get(['a', 'd'])->shouldYield(new \ArrayIterator(['a' => null, 'd' => null]));
    }

    function it_can_delete_cache_entry()
    {
        $this->delete('e')->shouldBe(false);
        $this->delete('a')->shouldBe(true);
        $this->get('a')->shouldReturn(null);
        $this->get('a', 111)->shouldReturn(111);
    }

    function it_can_delete_several_cache_entries()
    {
        $this->delete(['b', 'd'])->shouldBe(false);

        $this->set('d', '111');
        $this->delete(['a', 'd'])->shouldBe(true);
        $this->get(['a', 'b'])->shouldYield(new \ArrayIterator(['a' => null, 'b' => null]));
    }

    function it_can_clear_all_cache_entries()
    {
        $this->clear()->shouldBe(true);
        $this->get(['a', 'b', 'c'])->shouldYield(new \ArrayIterator(['a' => null, 'b' => null, 'c' => null]));
    }

    function it_validate_cache_key()
    {
        $this->shouldThrow(\RuntimeException::class)->during('set', [null, 'value']);
        $this->shouldThrow(\RuntimeException::class)->during('set', ['', 'value']);
        $this->shouldThrow(\RuntimeException::class)->during('set', [0, 'value']);
        $this->shouldThrow(\RuntimeException::class)->during('set', [false, 'value']);

        $this->shouldThrow(\RuntimeException::class)->during('set', [true, 'value']);
        $this->shouldThrow(\RuntimeException::class)->during('set', [1111, 'value']);
        $this->shouldThrow(\RuntimeException::class)->during('set', [1.1, 'value']);
        $this->shouldThrow(\RuntimeException::class)->during('set', [new \Exception(), 'value']);

        $this->shouldThrow(\RuntimeException::class)->during('set', [str_repeat('a', 65), 'value']);

        $this->shouldThrow(\RuntimeException::class)->during('set', ['{', 'value']);
        $this->shouldThrow(\RuntimeException::class)->during('set', ['}', 'value']);
        $this->shouldThrow(\RuntimeException::class)->during('set', ['(', 'value']);
        $this->shouldThrow(\RuntimeException::class)->during('set', [')', 'value']);
        $this->shouldThrow(\RuntimeException::class)->during('set', ['/', 'value']);
        $this->shouldThrow(\RuntimeException::class)->during('set', ['\\', 'value']);
        $this->shouldThrow(\RuntimeException::class)->during('set', ['@', 'value']);
        $this->shouldThrow(\RuntimeException::class)->during('set', [':', 'value']);

        $this->shouldThrow(\RuntimeException::class)->during('setMultiple', ['a']);

        $g = function ($a, $z) {
            foreach (range($a, $z) as $char) {
                yield $char => $char;
            }
        };
        $this->shouldNotThrow(\RuntimeException::class)->during('get', [$g('a', 'a'), 111]);
        $this->shouldNotThrow(\RuntimeException::class)->during('get', [$g('a', 'b'), 111]);
        $this->shouldNotThrow(\RuntimeException::class)->during('setMultiple', [$g('a', 'b'), 111]);
        $this->shouldNotThrow(\RuntimeException::class)->during('delete', [$g('a', 'b'), 111]);
        $this->shouldNotThrow(\RuntimeException::class)->during('get', [new \ArrayIterator(['a', 'b']), 111]);
    }

    function it_validates_ttl()
    {
        $this->shouldThrow(\RuntimeException::class)->during('set', ['a', 'value', 'abc']);
        $this->shouldThrow(\RuntimeException::class)->during('set', ['a', 'value', true]);
        $this->shouldThrow(\RuntimeException::class)->during('set', ['a', 'value', 11.1]);
        $this->shouldThrow(\RuntimeException::class)->during('set', ['a', 'value', [111]]);

        $this->shouldThrow(\RuntimeException::class)->during('set', ['a', 'value', '-111']);

        $this->shouldNotThrow(\Exception::class)->during('set', ['a', 'value', -111]);
        $this->shouldNotThrow(\Exception::class)->during('set', ['a', 'value', '111']);

        $this->shouldNotThrow(\Exception::class)->during('set', ['a', 'value', \DateInterval::createFromDateString('1 day')]);
    }
}
