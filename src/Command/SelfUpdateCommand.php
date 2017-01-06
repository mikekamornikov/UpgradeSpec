<?php

namespace Sugarcrm\UpgradeSpec\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Humbug\SelfUpdate\Updater;
use Humbug\SelfUpdate\Strategy\GithubStrategy;

class SelfUpdateCommand extends Command
{
    /**
     *  Configure the command
     */
    protected function configure()
    {
        $this->setName('self:update')
            ->setDescription('Update uspec to the latest version')
            ->addOption('stability', 's',
                InputOption::VALUE_OPTIONAL,
                'Release stability (stable, unstable, any)',
                GithubStrategy::ANY
            );
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
        try {
            $this->validateInput($input);
            $updater = $this->prepareUpdater($input->getOption('stability'));

            if ($updater->update()) {
                $output->writeln(sprintf('<info>Successfully updated from "%s" to "%s"</info>',
                    $updater->getOldVersion(),
                    $updater->getNewVersion()
                ));
            } else {
                $output->writeln('<info>No update needed!</info>');
            }
        } catch (\Exception $e) {
            $output->writeln(sprintf('<error>%s</error>', $e->getMessage()));
        }
    }

    /**
     * @param $stability
     * @return Updater
     */
    private function prepareUpdater($stability)
    {
        $version = $this->getApplication()->getVersion();

        $updater = new Updater();
        $updater->setStrategy(Updater::STRATEGY_GITHUB);
        $updater->getStrategy()->setPackageName('mikekamornikov/uspec');
        $updater->getStrategy()->setPharName('uspec.phar');
        $updater->getStrategy()->setCurrentLocalVersion($version);
        $updater->getStrategy()->setStability($stability);
        $updater->setBackupPath(sys_get_temp_dir() . '/uspec-old.phar');

        return $updater;
    }

    private function validateInput(InputInterface $input)
    {
        $stability = $input->getOption('stability');
        if (!in_array($stability, [GithubStrategy::STABLE, GithubStrategy::UNSTABLE, GithubStrategy::ANY])) {
            throw new \RuntimeException('Invalid "stability" option value');
        }
    }
}
