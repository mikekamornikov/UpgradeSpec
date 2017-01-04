<?php

namespace Sugarcrm\UpgradeSpec\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateSpecCommand extends Command
{
    /**
     *  Configure the command
     */
    protected function configure()
    {
        $this->setName('generate:spec')
            ->setDescription('Generate a new upgrade spec')
            ->addArgument('path', InputArgument::REQUIRED, 'Path to SugarCRM build we are going to upgrade')
            ->addArgument('version', InputArgument::OPTIONAL, 'Desired version to upgrade to');
    }

    /**
     * Execute the command
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $version = $input->getArgument('version') ?: 'latest';
        $path = $input->getArgument('path');

        $output->writeln(sprintf('<info>Generating upgrade spec for "%s" (to version "%s")</info>', $path, $version));
        $output->writeln('<info>Done</info>');
    }
}
