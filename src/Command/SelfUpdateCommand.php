<?php

namespace Sugarcrm\UpgradeSpec\Command;

use Sugarcrm\UpgradeSpec\Updater\UpdaterInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class SelfUpdateCommand extends Command
{
    /**
     * @var Updater
     */
    private $updater;

    /**
     * SelfUpdateCommand constructor.
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
        $this->setName('self:update')
            ->setDescription('Update uspec to the latest version')
            ->addOption('stability', 's',
                InputOption::VALUE_OPTIONAL,
                'Release stability (stable, unstable, any)',
                UpdaterInterface::STABILITY_ANY
            );
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
     * Validate user input
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
            UpdaterInterface::STABILITY_STABLE,
            UpdaterInterface::STABILITY_UNSTABLE,
            UpdaterInterface::STABILITY_ANY
        ])) {
            throw new \RuntimeException('Invalid "stability" option value');
        }
    }
}
