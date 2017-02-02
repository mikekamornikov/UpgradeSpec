<?php

namespace spec\Sugarcrm\UpgradeSpec\Command;

use Prophecy\Argument;
use PhpSpec\ObjectBehavior;
use Sugarcrm\UpgradeSpec\Command\GenerateSpecCommand;
use Sugarcrm\UpgradeSpec\Data\Manager;
use Sugarcrm\UpgradeSpec\Spec\Context;
use Sugarcrm\UpgradeSpec\Spec\Generator;
use Sugarcrm\UpgradeSpec\Helper\File;
use Sugarcrm\UpgradeSpec\Helper\Sugarcrm;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateSpecCommandSpec extends ObjectBehavior
{
    function let(InputInterface $input, Generator $generator, Manager $dataManager, Sugarcrm $sugarcrmHelper, File $fileHelper)
    {
        $input->bind(Argument::cetera())->willReturn();
        $input->hasArgument(Argument::any())->willReturn();
        $input->isInteractive()->willReturn(false);
        $input->validate()->willReturn();
        $input->getArgument('path')->willReturn('/path/to/sugarcrm/build');
        $input->getArgument('version')->willReturn('7.8');
        $input->hasParameterOption('--dump')->willReturn(false);
        $input->hasParameterOption('-D')->willReturn(false);

        $input->hasParameterOption('--packagesPath')->willReturn(false);
        $input->hasParameterOption('-P')->willReturn(false);

        $generator->generate(Argument::cetera())->willReturn('generated_spec');

        $dataManager->getLatestVersion(Argument::cetera())->willReturn('7.8.0.0');

        $sugarcrmHelper->isSugarcrmBuild(Argument::cetera())->willReturn(true);
        $sugarcrmHelper->getBuildVersion(Argument::cetera())->willReturn('7.6.1');
        $sugarcrmHelper->getBuildFlav(Argument::cetera())->willReturn('ULT');

        $fileHelper->saveToFile(Argument::cetera())->willReturn();

        $this->beConstructedWith(null, $generator, $dataManager, $sugarcrmHelper, $fileHelper);
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

    function it_has_optional_version_argument_defaulting_to_latest(Generator $generator, InputInterface $input, OutputInterface $output)
    {
        $input->getArgument('version')->willReturn();

        $this->run($input, $output);

        $context = new Context('7.6.1', '7.8.0.0', 'ULT');
        $generator->generate($context)->shouldBeCalled();
    }

    function it_generates_upgrade_spec(InputInterface $input, OutputInterface $output)
    {
        $this->run($input, $output);
        $output->writeln('<info>generated_spec</info>')->shouldHaveBeenCalled();
        $output->writeln('<comment>Done</comment>')->shouldHaveBeenCalled();
    }

    function it_shows_error_for_upgrades_to_version_equal_to_given_instance_version(InputInterface $input, OutputInterface $output, Manager $dataManager, Sugarcrm $sugarcrmHelper)
    {
        $input->getArgument('version')->willReturn('7.7');
        $dataManager->getLatestVersion(Argument::cetera())->willReturn('7.7.1');
        $sugarcrmHelper->getBuildVersion(Argument::cetera())->willReturn('7.7.1');

        $output->writeln('<error>Given version ("7.7.1") is lower or equal to the build version ("7.7.1")</error>')->shouldBeCalled();

        $this->run($input, $output);
    }

    function it_shows_error_for_upgrades_to_version_lower_than_given_instance_version(InputInterface $input, OutputInterface $output, Manager $dataManager, Sugarcrm $sugarcrmHelper)
    {
        $input->getArgument('version')->willReturn('7.7');
        $dataManager->getLatestVersion(Argument::cetera())->willReturn('7.7.1');
        $sugarcrmHelper->getBuildVersion(Argument::cetera())->willReturn('7.8.0.0');

        $output->writeln('<error>Given version ("7.7.1") is lower or equal to the build version ("7.8.0.0")</error>')->shouldBeCalled();

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
