<?php

namespace spec\Sugarcrm\UpgradeSpec\Cache\Adapter;

use Sugarcrm\UpgradeSpec\Cache\Adapter\File;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class FileSpec extends ObjectBehavior
{
    use SimpleCacheSpecTrait;

    /**
     * @var string
     */
    private $cachePath;

    function let()
    {
        $this->cachePath = sys_get_temp_dir() . '/.uspec_test_cache';

        $this->beConstructedWith($this->cachePath);
        $this->setMultiple($this->data);
    }

    function letGo()
    {
        if (file_exists($this->cachePath)) {
            $this->clear();
        }
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(File::class);
    }
}
