<?php

namespace Sugarcrm\UpgradeSpec\Command;

use Sugarcrm\UpgradeSpec\Generator\Generator;
use Sugarcrm\UpgradeSpec\Utils;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateSpecCommand extends Command
{
    /**
     * @var Generator
     */
    private $specGenerator;

    /**
     * @var Utils
     */
    private $utils;

    /**
     * GenerateSpecCommand constructor.
     * @param null $name
     * @param Generator $specGenerator
     */
    public function __construct($name = null, Generator $specGenerator, Utils $utils)
    {
        parent::__construct($name);

        $this->specGenerator = $specGenerator;
        $this->utils = $utils;
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
        $version = $this->utils->getBuildVersion($path);

        // TODO: get real "latest" version in the runtime
        $upgradeTo = $input->getArgument('version') ?: '7.8';

        $output->writeln(sprintf('<comment>Generating upgrade spec for "%s" (to version "%s") ...</comment>', $path, $upgradeTo));

        $spec = $this->specGenerator->generate($version, $upgradeTo);

        if ($input->hasOption('dump')) {
            $this->utils->saveToFile(sprintf('upgrade_%s_to_%s.md', $version, $upgradeTo), $spec);
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
        $this->validateVersion($this->utils->getBuildVersion($path), $version);
    }

    /**
     * @param $path
     */
    private function validatePath($path)
    {
        if (!$this->utils->isSugarcrmBuild($path)) {
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
