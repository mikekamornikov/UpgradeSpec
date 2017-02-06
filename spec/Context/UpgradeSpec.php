<?php

namespace spec\Sugarcrm\UpgradeSpec\Context;

use Sugarcrm\UpgradeSpec\Context\Target;
use Sugarcrm\UpgradeSpec\Context\TestBuild;
use Sugarcrm\UpgradeSpec\Context\Upgrade;
use PhpSpec\ObjectBehavior;
use Sugarcrm\UpgradeSpec\Version\Version;

class UpgradeSpec extends ObjectBehavior
{
    /**
     * @var Version
     */
    private $buildVersion;

    /**
     * @var Version
     */
    private $targetVersion;

    /**
     * @var string
     */
    private $flav = 'ULT';

    function let()
    {
        $this->buildVersion = new Version('7.6.1');
        $this->targetVersion = new Version('7.8.0.0');

        $this->beConstructedWith(
            new TestBuild($this->buildVersion, $this->flav, '/path/to/build'),
            new Target($this->targetVersion, $this->flav, '/path/to/upgrade/packages')
        );
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Upgrade::class);
    }

    function it_stores_build_version()
    {
        $this->getBuildVersion()->shouldReturn($this->buildVersion);
    }

    function it_stores_upgrade_version()
    {
        $this->getTargetVersion()->shouldReturn($this->targetVersion);
    }

    function it_stores_flav()
    {
        $this->getBuildFlav()->shouldReturn($this->flav);
    }

    function it_can_be_used_as_a_string()
    {
        $this->__toString()->shouldReturn('7.6.1(ULT) -> 7.8.0.0(ULT)');
    }

    function it_can_be_used_as_filename()
    {
        $this->asFilename()->shouldReturn('upgrade_7.6.1(ULT)_to_7.8.0.0(ULT)');
    }
}
