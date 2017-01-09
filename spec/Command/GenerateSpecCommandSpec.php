<?php

namespace spec\Sugarcrm\UpgradeSpec\Command;

use Prophecy\Argument;
use Sugarcrm\UpgradeSpec\Command\GenerateSpecCommand;
use PhpSpec\ObjectBehavior;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateSpecCommandSpec extends ObjectBehavior
{
    function let(InputInterface $input)
    {
        $input->bind(Argument::cetera())->willReturn();
        $input->hasArgument(Argument::any())->willReturn();
        $input->isInteractive()->willReturn(false);
        $input->validate()->willReturn();
        $input->getArgument('path')->willReturn('/a/path/to/existing/sugarcrm/build');
        $input->getArgument('version')->willReturn('7.8');
    }
    
    function it_is_initializable()
    {
        $this->shouldHaveType(GenerateSpecCommand::class);
    }

    function it_has_a_name()
    {
        $this->getName()->shouldReturn('generate:spec');
    }

//    function it_has_required_path_argument()
//    {
//
//    }
//
//    function it_has_optional_version_argument_defaulting_to_latest()
//    {
//
//    }
    
    function it_generates_upgrade_spec(InputInterface $input, OutputInterface $output)
    {
        $this->run($input, $output);
        $output->writeln('<info>Done</info>')->shouldHaveBeenCalled();
    }

//    function it_shows_error_for_invalid_path()
//    {
//
//    }
//
//    function it_shows_error_for_not_sugarcrm_instance_path()
//    {
//
//    }
//
//    function it_shows_error_for_upgrades_to_version_lower_or_equal_to_given_instance_version()
//    {
//
//    }
//
//    function it_has_dump_option_to_save_spec_to_file()
//    {
//
//    }
}
