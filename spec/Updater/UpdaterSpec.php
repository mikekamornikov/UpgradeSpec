<?php

namespace spec\Sugarcrm\UpgradeSpec\Updater;

use Sugarcrm\UpgradeSpec\Updater\Adapter\AdapterInterface;
use Sugarcrm\UpgradeSpec\Updater\Exception\UpdaterException;
use PhpSpec\ObjectBehavior;
use Sugarcrm\UpgradeSpec\Updater\UpdaterInterface;

class UpdaterSpec extends ObjectBehavior
{
    function let(AdapterInterface $adapter)
    {
        $this->beConstructedWith($adapter);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(UpdaterInterface::class);
    }

    function it_checks_for_available_updates(AdapterInterface $adapter)
    {
        $adapter->hasUpdate()->shouldBeCalled();

        $adapter->hasUpdate()->willReturn(true);
        $this->hasUpdate()->shouldReturn(true);

        $adapter->hasUpdate()->willReturn(false);
        $this->hasUpdate()->shouldReturn(false);
    }

    function it_knows_old_and_new_version_numbers(AdapterInterface $adapter)
    {
        $adapter->getOldVersion()->shouldBeCalled();
        $adapter->getOldVersion()->willReturn('v0.1.2');
        $this->getOldVersion()->shouldReturn('v0.1.2');

        $adapter->getNewVersion()->shouldBeCalled();
        $adapter->getNewVersion()->willReturn('v0.2');
        $this->getNewVersion()->shouldReturn('v0.2');
    }

    function it_updates_application_to_new_version(AdapterInterface $adapter)
    {
        $stability = UpdaterInterface::STABILITY_ANY;
        $adapter->update($stability)->shouldBeCalled();
        $adapter->update($stability)->willReturn(true);
        $this->update($stability)->shouldReturn(true);
    }

    function it_validates_stability_on_update()
    {
        $this->shouldThrow(UpdaterException::class)->duringUpdate('invalid_stability');
    }

    function it_updates_application_to_previous_version(AdapterInterface $adapter)
    {
        $adapter->rollback()->shouldBeCalled();
        $adapter->rollback()->willReturn(true);
        $this->rollback()->shouldReturn(true);
    }
}
