<?php

namespace Sugarcrm\UpgradeSpec\Command;

use Sugarcrm\UpgradeSpec\Generator\Generator;
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
     * GenerateSpecCommand constructor.
     * @param null $name
     * @param Generator $specGenerator
     */
    public function __construct($name = null, Generator $specGenerator)
    {
        parent::__construct($name);

        $this->specGenerator = $specGenerator;
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
        $upgradeTo = $input->getArgument('version') ?: 'latest';
        $path = $input->getArgument('path');
        $buildVersion = $this->getBuildVersion($path);

        $output->writeln(sprintf('<comment>Generating upgrade spec for "%s" (to version "%s") ...</comment>', $path, $upgradeTo));

        $output->writeln(sprintf('<info>%s</info>', $this->specGenerator->generate($buildVersion, $upgradeTo)));

        $output->writeln('<comment>Done</comment>');

        return 0;
    }

    /**
     * @param $path
     * @return string
     */
    private function getBuildVersion($path)
    {
        // TODO: implement the logic and move it to appropriate place
        return '7.5';
    }
}
