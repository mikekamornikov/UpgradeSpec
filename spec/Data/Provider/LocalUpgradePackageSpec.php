<?php

namespace spec\Sugarcrm\UpgradeSpec\Data\Provider;

use Sugarcrm\UpgradeSpec\Data\Provider\LocalUpgradePackage;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Sugarcrm\UpgradeSpec\Data\Provider\PackageDataProviderInterface;
use Sugarcrm\UpgradeSpec\Data\Provider\ProviderInterface;

class LocalUpgradePackageSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(LocalUpgradePackage::class);
    }

    function it_is_provider()
    {
        $this->shouldHaveType(ProviderInterface::class);
    }

    function it_is_package_data_provider()
    {
        $this->shouldHaveType(PackageDataProviderInterface::class);
    }
}
