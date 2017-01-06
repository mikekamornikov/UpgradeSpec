<?php

namespace Sugarcrm\UpgradeSpec\Command;

use Humbug\SelfUpdate\Updater;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SelfRollbackCommand extends Command
{
    /**
     *  Configure the command
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
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $updater = $this->prepareUpdater();

        try {
            if (!$updater->rollback()) {
                $output->writeln('<error>Before rollback you need to perform at least one update.</error>');
                return;
            }

            $output->writeln('<info>Success!</info>');
        } catch (\Exception $e) {
            $output->writeln(sprintf('<error>%s</error>', $e->getMessage()));
        }
    }

    /**
     * @return Updater
     */
    protected function prepareUpdater()
    {
        $updater = new Updater();
        $updater->setRestorePath(sys_get_temp_dir() . '/uspec-old.phar');
        
        return $updater;
    }
}
