<?php

namespace spec\Sugarcrm\UpgradeSpec\Command;

use Prophecy\Argument;
use Sugarcrm\UpgradeSpec\Command\SelfUpdateCommand;
use Sugarcrm\UpgradeSpec\Updater\Updater;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use PhpSpec\ObjectBehavior;

class SelfUpdateCommandSpec extends ObjectBehavior
{
    function let(InputInterface $input, Updater $updater)
    {
        $input->bind(Argument::cetera())->willReturn();
        $input->hasArgument(Argument::any())->willReturn();
        $input->isInteractive()->willReturn(false);
        $input->validate()->willReturn();
        $input->getOption('stability')->willReturn(Updater::STABILITY_ANY);

        $updater->update(Argument::any())->willReturn(true);

        $this->beConstructedWith(null, $updater);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(SelfUpdateCommand::class);
    }

    function it_has_a_name()
    {
        $this->getName()->shouldReturn('self:update');
    }

    function it_validates_user_input(InputInterface $input, OutputInterface $output)
    {
        $input->getOption('stability')->willReturn('invalid_stability');
        $output->writeln('<error>Invalid "stability" option value</error>')->shouldBeCalled();

        $this->run($input, $output);
    }

    function it_checks_if_update_is_needed(Updater $updater, InputInterface $input, OutputInterface $output)
    {
        $updater->hasUpdate()->willReturn(false);
        $input->getOption('stability')->willReturn(Updater::STABILITY_ANY);
        $output->writeln('<info>No update needed!</info>')->shouldBeCalled();

        $this->run($input, $output);
    }

    function it_updates_application_to_new_version(Updater $updater, InputInterface $input, OutputInterface $output)
    {
        $updater->hasUpdate()->willReturn(true);
        $updater->getOldVersion()->willReturn('1.2.3');
        $updater->getNewVersion()->willReturn('1.2.4');
        $input->getOption('stability')->willReturn(Updater::STABILITY_ANY);
        $output->writeln('<info>Successfully updated from "1.2.3" to "1.2.4"</info>')->shouldBeCalled();

        $this->run($input, $output);
    }
}
