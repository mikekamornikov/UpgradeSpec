<?php

namespace spec\Sugarcrm\UpgradeSpec\Data\Provider;

use Sugarcrm\UpgradeSpec\Data\Provider\Doc\DocProviderInterface;
use Sugarcrm\UpgradeSpec\Data\Provider\Memory;
use PhpSpec\ObjectBehavior;
use Sugarcrm\UpgradeSpec\Data\Provider\ProviderInterface;
use Sugarcrm\UpgradeSpec\Data\Provider\SourceCode\SourceCodeProviderInterface;

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
        $this->shouldHaveType(SourceCodeProviderInterface::class);
    }
}
