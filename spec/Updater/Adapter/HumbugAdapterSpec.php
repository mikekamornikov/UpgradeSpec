<?php

namespace spec\Sugarcrm\UpgradeSpec\Updater\Adapter;

use Humbug\SelfUpdate\Strategy\GithubStrategy;
use Humbug\SelfUpdate\Updater;
use Prophecy\Argument;
use Sugarcrm\UpgradeSpec\Updater\Adapter\AdapterInterface;
use Sugarcrm\UpgradeSpec\Updater\Adapter\HumbugAdapter;
use PhpSpec\ObjectBehavior;

class HumbugAdapterSpec extends ObjectBehavior
{
    function let(Updater $updater, GithubStrategy $strategy)
    {
        $strategy->setStability(Argument::any())->willReturn();

        $updater->getStrategy()->willReturn($strategy);
        $updater->update()->willReturn();
        $updater->getTempDirectory()->willReturn();
        $updater->getLocalPharFileBasename()->willReturn();

        $this->beConstructedWith($updater);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(HumbugAdapter::class);
        $this->shouldHaveType(AdapterInterface::class);
    }

    function it_checks_for_available_updates(Updater $updater)
    {
        $updater->hasUpdate()->shouldBeCalled();

        $updater->hasUpdate()->willReturn(true);
        $this->hasUpdate()->shouldReturn(true);

        $updater->hasUpdate()->willReturn(false);
        $this->hasUpdate()->shouldReturn(false);
    }

    function it_knows_old_and_new_version_numbers(Updater $updater)
    {
        $updater->getOldVersion()->shouldBeCalled();
        $updater->getOldVersion()->willReturn('v0.1.2');
        $this->getOldVersion()->shouldReturn('v0.1.2');

        $updater->getNewVersion()->shouldBeCalled();
        $updater->getNewVersion()->willReturn('v0.2');
        $this->getNewVersion()->shouldReturn('v0.2');
    }

    function it_updates_application_to_new_version(Updater $updater)
    {
        $updater->update()->shouldBeCalled();
        $updater->update()->willReturn(true);
        $this->update()->shouldReturn(true);
    }

    function it_defaults_to_any_stability_on_update(GithubStrategy $strategy)
    {
        $strategy->setStability(GithubStrategy::ANY)->shouldBeCalled();
        $this->update();
    }

    function it_accepts_invalid_stability_on_update(GithubStrategy $strategy)
    {
        $strategy->setStability(GithubStrategy::ANY)->shouldBeCalled();
        $this->update('invalid_stability');
    }

    function it_updates_application_to_previous_version(Updater $updater)
    {
        $updater->rollback()->shouldBeCalled();
        $updater->rollback()->willReturn(true);
        $this->rollback()->shouldReturn(true);
    }
}
