<?php

namespace Sugarcrm\UpgradeSpec\Command;

use Sugarcrm\UpgradeSpec\Spec\Generator;
use Sugarcrm\UpgradeSpec\Helper\File;
use Sugarcrm\UpgradeSpec\Helper\Sugarcrm;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateSpecCommand extends Command
{
    /**
     * @var SpecGenerator
     */
    private $specGenerator;
    /**
     * @var Sugarcrm
     */
    private $sugarcrmHelper;

    /**
     * @var File
     */
    private $fileHelper;

    /**
     * GenerateSpecCommand constructor.
     * @param null $name
     * @param SpecGenerator $specGenerator
     * @param Sugarcrm $sugarcrmHelper
     * @param File $fileHelper
     */
    public function __construct($name = null, Generator $specGenerator, Sugarcrm $sugarcrmHelper, File $fileHelper)
    {
        parent::__construct($name);

        $this->specGenerator = $specGenerator;
        $this->sugarcrmHelper = $sugarcrmHelper;
        $this->fileHelper = $fileHelper;
    }

    /**
     *  Configure the command
     */
    protected function configure()
    {
        $this->setName('generate:spec')
            ->setDescription('Generate a new upgrade spec')
            ->addArgument('path', InputArgument::REQUIRED, 'Path to SugarCRM build we are going to upgrade')
            ->addArgument('version', InputArgument::OPTIONAL, 'Version to upgrade to')
            ->addOption('dump', 'D', InputOption::VALUE_NONE, 'Save generated spec to file');
    }

    /**
     * Execute the command
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $path = $input->getArgument('path');
        $version = $this->sugarcrmHelper->getBuildVersion($path);

        // TODO: get real "latest" version in the runtime
        $upgradeTo = $input->getArgument('version') ?: '7.8';

        $output->writeln(sprintf('<comment>Generating upgrade spec ...</comment>', $path, $upgradeTo));

        $spec = $this->specGenerator->generate($version, $upgradeTo);

        if ($input->hasParameterOption('--dump') || $input->hasParameterOption('-D')) {
            $this->fileHelper->saveToFile(sprintf('upgrade_%s_to_%s.md', $version, $upgradeTo), $spec);
        } else {
            $output->writeln(sprintf('<info>%s</info>', $spec));
        }

        $output->writeln('<comment>Done</comment>');

        return 0;
    }

    /**
     * @param InputInterface $input
     */
    protected function validateInput(InputInterface $input)
    {
        $path = $input->getArgument('path');
        $version = $input->getArgument('version');

        $this->validatePath($path);
        $this->validateVersion($this->sugarcrmHelper->getBuildVersion($path), $version);
    }

    /**
     * @param $path
     */
    private function validatePath($path)
    {
        if (!$this->sugarcrmHelper->isSugarcrmBuild($path)) {
            throw new \InvalidArgumentException('Invalid "path" argument value');
        }
    }

    /**
     * @param $buildVersion
     * @param $upgradeTo
     */
    private function validateVersion($buildVersion, $upgradeTo)
    {
        // TODO: use composer/semver to validate versions
        if ($upgradeTo && version_compare($buildVersion, $upgradeTo, '>=')) {
            throw new \InvalidArgumentException('Invalid "version" argument value');
        }
    }
}
