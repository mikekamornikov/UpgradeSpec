<?php

namespace Sugarcrm\UpgradeSpec\Command;

use Sugarcrm\UpgradeSpec\Updater\Updater;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class SelfUpdateCommand extends Command implements PharContext
{
    /**
     * @var Updater
     */
    private $updater;

    /**
     * SelfUpdateCommand constructor.
     *
     * @param null    $name
     * @param Updater $updater
     */
    public function __construct($name, Updater $updater)
    {
        parent::__construct($name);

        $this->updater = $updater;
    }

    /**
     * Configure the command.
     */
    protected function configure()
    {
        $this->setName('self:update')
            ->setDescription('Update uspec to the latest version')
            ->addOption('stability', 's',
                InputOption::VALUE_OPTIONAL,
                'Release stability (stable, unstable, any)',
                Updater::STABILITY_ANY
            )
            ->addOption('rollback', 'r', InputOption::VALUE_NONE, 'Rollback uspec update');
    }

    /**
     * Execute the command.
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if ($input->hasParameterOption('--rollback') || $input->hasParameterOption('-r')) {
            return $this->rollback($input, $output);
        }

        return $this->update($input, $output);
    }

    /**
     * Validate user input.
     *
     * @param InputInterface $input
     */
    protected function validateInput(InputInterface $input)
    {
        $this->validateStability($input->getOption('stability'));
    }

    /**
     * @param $stability
     */
    private function validateStability($stability)
    {
        if (!in_array($stability, [
            Updater::STABILITY_STABLE,
            Updater::STABILITY_UNSTABLE,
            Updater::STABILITY_ANY,
        ])) {
            throw new \InvalidArgumentException('Invalid "stability" option value');
        }
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    private function update(InputInterface $input, OutputInterface $output)
    {
        if (!$this->updater->hasUpdate()) {
            $output->writeln('<info>No update needed!</info>');

            return 0;
        }

        $this->updater->update($input->getOption('stability'));

        $output->writeln(sprintf('<info>Successfully updated from "%s" to "%s"</info>',
            $this->updater->getOldVersion(),
            $this->updater->getNewVersion()
        ));

        return 0;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    private function rollback(InputInterface $input, OutputInterface $output)
    {
        if (!$this->updater->rollback()) {
            $output->writeln('<error>Before rollback you need to perform at least one update.</error>');

            return 1;
        }

        $output->writeln('<info>Success!</info>');

        return 0;
    }
}
