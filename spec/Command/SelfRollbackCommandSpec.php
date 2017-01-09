<?php

namespace spec\Sugarcrm\UpgradeSpec\Command;

use Sugarcrm\UpgradeSpec\Command\SelfRollbackCommand;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Sugarcrm\UpgradeSpec\Updater\UpdaterInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SelfRollbackCommandSpec extends ObjectBehavior
{
    function let(InputInterface $input, UpdaterInterface $updater)
    {
        $input->bind(Argument::cetera())->willReturn();
        $input->hasArgument(Argument::any())->willReturn();
        $input->isInteractive()->willReturn(false);
        $input->validate()->willReturn();

        $this->beConstructedWith(null, $updater);
    }
    
    function it_is_initializable()
    {
        $this->shouldHaveType(SelfRollbackCommand::class);
    }

    function it_has_a_name()
    {
        $this->getName()->shouldReturn('self:rollback');
    }

    function it_should_be_executed_after_update(UpdaterInterface $updater, InputInterface $input, OutputInterface $output)
    {
        $updater->rollback()->willReturn(false);
        $output->writeln('<error>Before rollback you need to perform at least one update.</error>')->shouldBeCalled();

        $this->run($input, $output);
    }

    function it_updates_application_to_previous_version(UpdaterInterface $updater, InputInterface $input, OutputInterface $output)
    {
        $updater->rollback()->willReturn(true);
        $output->writeln('<info>Success!</info>')->shouldBeCalled();

        $this->run($input, $output);
    }
}
