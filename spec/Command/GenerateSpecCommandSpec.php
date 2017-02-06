<?php

namespace spec\Sugarcrm\UpgradeSpec\Command;

use Prophecy\Argument;
use PhpSpec\ObjectBehavior;
use Sugarcrm\UpgradeSpec\Command\GenerateSpecCommand;
use Sugarcrm\UpgradeSpec\Context\Target;
use Sugarcrm\UpgradeSpec\Context\TestBuild;
use Sugarcrm\UpgradeSpec\Data\Manager;
use Sugarcrm\UpgradeSpec\Context\Upgrade;
use Sugarcrm\UpgradeSpec\Spec\Generator;
use Sugarcrm\UpgradeSpec\Version\Version;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateSpecCommandSpec extends ObjectBehavior
{
    /**
     * @var string
     */
    private $buildPath;

    /**
     * @var string
     */
    private $flav = 'ULT';

    /**
     * @var Upgrade
     */
    private $context;

    function let(InputInterface $input, Generator $generator, Manager $dataManager)
    {
        $this->createTestBuild('7.6.1', $this->flav);

        $this->context = new Upgrade(
            new TestBuild(new Version('7.6.1'), $this->flav, $this->buildPath),
            new Target(new Version('7.8'), $this->flav)
        );

        $input->bind(Argument::cetera())->willReturn();
        $input->hasArgument(Argument::any())->willReturn();
        $input->isInteractive()->willReturn(false);
        $input->validate()->willReturn();
        $input->getArgument('path')->willReturn($this->buildPath);
        $input->getArgument('version')->willReturn('7.8');
        $input->hasParameterOption('--dump')->willReturn(false);
        $input->hasParameterOption('-D')->willReturn(false);

        $input->hasParameterOption('--upgradeSource')->willReturn(false);
        $input->hasParameterOption('-U')->willReturn(false);

        $generator->generate(Argument::cetera())->willReturn('generated_spec');

        $dataManager->getLatestVersion(Argument::cetera())->willReturn('7.8.0.0');

        $this->beConstructedWith(null, $generator, $dataManager);
    }

    function letGo()
    {
        @unlink($this->buildPath. '/sugar_version.php');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(GenerateSpecCommand::class);
    }

    function it_has_a_name()
    {
        $this->getName()->shouldReturn('generate:spec');
    }

    function it_requires_valid_sugarcrm_build_path(InputInterface $input, OutputInterface $output)
    {
        @unlink($this->buildPath. '/sugar_version.php');
        $output->writeln('<error>Invalid "path" argument value</error>')->shouldBeCalled();

        $this->run($input, $output);
    }

    function it_has_optional_version_argument_defaulting_to_latest(Generator $generator, InputInterface $input, OutputInterface $output)
    {
        $input->getArgument('version')->willReturn();

        $this->run($input, $output);

        $generator->generate(Argument::that(function(Upgrade $context) {
            return $context->getTargetVersion() == '7.8.0.0';
        }))->shouldBeCalled();
    }

    function it_generates_upgrade_spec(InputInterface $input, OutputInterface $output)
    {
        $this->run($input, $output);
        $output->writeln('<info>generated_spec</info>')->shouldHaveBeenCalled();
        $output->writeln('<comment>Done</comment>')->shouldHaveBeenCalled();
    }

    function it_shows_error_for_upgrades_to_version_equal_to_given_instance_version(InputInterface $input, OutputInterface $output, Manager $dataManager)
    {
        $input->getArgument('version')->willReturn('7.7');
        $dataManager->getLatestVersion(Argument::cetera())->willReturn('7.7.1');
        $this->createTestBuild('7.7.1', 'ULT');

        $output->writeln('<error>Given version ("7.7.1") is lower or equal to the build version ("7.7.1")</error>')->shouldBeCalled();

        $this->run($input, $output);
    }

    function it_shows_error_for_upgrades_to_version_lower_than_given_instance_version(InputInterface $input, OutputInterface $output, Manager $dataManager)
    {
        $input->getArgument('version')->willReturn('7.7');
        $dataManager->getLatestVersion(Argument::cetera())->willReturn('7.7.1');
        $this->createTestBuild('7.8.0.0', 'ULT');

        $output->writeln('<error>Given version ("7.7.1") is lower or equal to the build version ("7.8.0.0")</error>')->shouldBeCalled();

        $this->run($input, $output);
    }

    function it_has_dump_option_to_save_spec_to_file(InputInterface $input, OutputInterface $output)
    {
        $spec = 'upgrade_7.6.1(ULT)_to_7.8.0.0(ULT).md';

        $input->hasParameterOption('--dump')->willReturn(true);
        $this->run($input, $output)->shouldExist($spec);
        @unlink($spec);

        $input->hasParameterOption('-D')->willReturn(true);
        $this->run($input, $output)->shouldExist($spec);
        @unlink($spec);
    }

    public function getMatchers()
    {
        return [
            'exist' => function ($subject, $file) {
                return file_exists($file);
            },
        ];
    }

    /**
     * Creates build dummy
     *
     * @param $version
     * @param $flav
     */
    private function createTestBuild($version, $flav)
    {
        $this->buildPath = sys_get_temp_dir();

        $data = <<<'EOL'
<?php
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
$sugar_version      = '{{version}}';
$sugar_db_version   = '{{version}}';
$sugar_flavor       = '{{flav}}';
$sugar_build        = '999';
$sugar_timestamp    = '2008-08-01 12:00am';
EOL;

        $data = str_replace(['{{version}}', '{{flav}}'], [$version, $flav], $data);
        file_put_contents($this->buildPath. '/sugar_version.php', $data);
    }
}
