<?php

namespace spec\Sugarcrm\UpgradeSpec\Command;

use Prophecy\Argument;
use PhpSpec\ObjectBehavior;
use Sugarcrm\UpgradeSpec\Command\GenerateSpecCommand;
use Sugarcrm\UpgradeSpec\Generator\SpecGenerator;
use Sugarcrm\UpgradeSpec\Helper\File;
use Sugarcrm\UpgradeSpec\Helper\Sugarcrm;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateSpecCommandSpec extends ObjectBehavior
{
    function let(InputInterface $input, SpecGenerator $generator, Sugarcrm $sugarcrmHelper, File $fileHelper)
    {
        $input->bind(Argument::cetera())->willReturn();
        $input->hasArgument(Argument::any())->willReturn();
        $input->isInteractive()->willReturn(false);
        $input->validate()->willReturn();
        $input->getArgument('path')->willReturn('/path/to/sugarcrm/build');
        $input->getArgument('version')->willReturn('7.8');
        $input->hasParameterOption('--dump')->willReturn(false);
        $input->hasParameterOption('-D')->willReturn(false);

        $generator->generate(Argument::cetera())->willReturn('generated_spec');

        $sugarcrmHelper->isSugarcrmBuild(Argument::cetera())->willReturn(true);
        $sugarcrmHelper->getBuildVersion(Argument::cetera())->willReturn('7.0');

        $fileHelper->saveToFile(Argument::cetera())->willReturn();

        $this->beConstructedWith(null, $generator, $sugarcrmHelper, $fileHelper);
    }
    
    function it_is_initializable()
    {
        $this->shouldHaveType(GenerateSpecCommand::class);
    }

    function it_has_a_name()
    {
        $this->getName()->shouldReturn('generate:spec');
    }

    function it_requires_valid_sugarcrm_build_path(InputInterface $input, OutputInterface $output, Sugarcrm $sugarcrmHelper)
    {
        $sugarcrmHelper->isSugarcrmBuild(Argument::cetera())->willReturn(false);

        $output->writeln('<error>Invalid "path" argument value</error>')->shouldBeCalled();

        $this->run($input, $output);
    }

    function it_has_optional_version_argument_defaulting_to_latest(SpecGenerator $generator, InputInterface $input, OutputInterface $output)
    {
        $input->getArgument('version')->willReturn();

        $this->run($input, $output);

        $latest = '7.8';
        $generator->generate(Argument::any(), $latest)->shouldBeCalled();
    }

    function it_generates_upgrade_spec(InputInterface $input, OutputInterface $output)
    {
        $this->run($input, $output);
        $output->writeln('<info>generated_spec</info>')->shouldHaveBeenCalled();
        $output->writeln('<comment>Done</comment>')->shouldHaveBeenCalled();
    }

    function it_shows_error_for_upgrades_to_version_lower_or_equal_to_given_instance_version(InputInterface $input, OutputInterface $output, Sugarcrm $sugarcrmHelper)
    {
        $input->getArgument('version')->willReturn('7.8');
        $sugarcrmHelper->getBuildVersion(Argument::cetera())->willReturn('7.8');

        $output->writeln('<error>Invalid "version" argument value</error>')->shouldBeCalled();

        $this->run($input, $output);
    }

    function it_has_dump_option_to_save_spec_to_file(InputInterface $input, OutputInterface $output, Sugarcrm $sugarcrmHelper, File $fileHelper)
    {
        $input->hasParameterOption('--dump')->willReturn(true);
        $sugarcrmHelper->getBuildVersion(Argument::cetera())->willReturn('7.0');
        $fileHelper->saveToFile(Argument::cetera())->shouldBeCalled();

        $this->run($input, $output);

        $input->hasParameterOption('-D')->willReturn(true);
        $sugarcrmHelper->getBuildVersion(Argument::cetera())->willReturn('7.0');
        $fileHelper->saveToFile(Argument::cetera())->shouldBeCalled();

        $this->run($input, $output);
    }
}
