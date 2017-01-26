<?php

namespace spec\Sugarcrm\UpgradeSpec\Data\Provider;

use Sugarcrm\UpgradeSpec\Data\Provider\DocProviderInterface;
use Sugarcrm\UpgradeSpec\Data\Provider\Memory;
use PhpSpec\ObjectBehavior;
use Sugarcrm\UpgradeSpec\Data\Provider\PackageDataProviderInterface;
use Sugarcrm\UpgradeSpec\Data\Provider\ProviderInterface;

class MemorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Memory::class);
    }

    function it_is_provider()
    {
        $this->shouldHaveType(ProviderInterface::class);
    }

    function it_is_doc_provider()
    {
        $this->shouldHaveType(DocProviderInterface::class);
    }

    function it_is_package_data_provider()
    {
        $this->shouldHaveType(PackageDataProviderInterface::class);
    }
}
