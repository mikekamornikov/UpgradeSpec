<?php

namespace Sugarcrm\UpgradeSpec\Command;

use Sugarcrm\UpgradeSpec\Updater\UpdaterInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SelfRollbackCommand extends Command
{
    /**
     * @var Updater
     */
    private $updater;

    /**
     * SelfRollbackCommand constructor.
     * @param null $name
     * @param UpdaterInterface $updater
     */
    public function __construct($name = null, UpdaterInterface $updater)
    {
        parent::__construct($name);

        $this->updater = $updater;
    }
    
    /**
     * Configure the command
     */
    protected function configure()
    {
        $this->setName('self:rollback')
            ->setDescription('Rollback uspec update');
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
        if (!$this->updater->rollback()) {
            $output->writeln('<error>Before rollback you need to perform at least one update.</error>');

            return 1;
        }

        $output->writeln('<info>Success!</info>');

        return 0;
    }
}
