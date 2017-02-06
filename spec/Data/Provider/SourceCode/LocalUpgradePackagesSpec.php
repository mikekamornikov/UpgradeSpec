<?php

namespace spec\Sugarcrm\UpgradeSpec\Data\Provider\SourceCode;

use PhpSpec\ObjectBehavior;
use Sugarcrm\UpgradeSpec\Data\Provider\ProviderInterface;
use Sugarcrm\UpgradeSpec\Data\Provider\SourceCode\LocalUpgradePackages;
use Sugarcrm\UpgradeSpec\Data\Provider\SourceCode\SourceCodeProviderInterface;

class LocalUpgradePackagesSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(LocalUpgradePackages::class);
    }

    function it_is_provider()
    {
        $this->shouldHaveType(ProviderInterface::class);
    }

    function it_is_package_data_provider()
    {
        $this->shouldHaveType(SourceCodeProviderInterface::class);
    }
}
