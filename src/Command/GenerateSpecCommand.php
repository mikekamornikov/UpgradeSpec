<?php

namespace Sugarcrm\UpgradeSpec\Command;

use Sugarcrm\UpgradeSpec\Context\Build;
use Sugarcrm\UpgradeSpec\Context\Target;
use Sugarcrm\UpgradeSpec\Data\Manager;
use Sugarcrm\UpgradeSpec\Helper\File;
use Sugarcrm\UpgradeSpec\Helper\Sugarcrm;
use Sugarcrm\UpgradeSpec\Context\Upgrade;
use Sugarcrm\UpgradeSpec\Spec\Generator;
use Sugarcrm\UpgradeSpec\Version\Version;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateSpecCommand extends Command
{
    /**
     * @var Generator
     */
    private $generator;

    /**
     * @var Sugarcrm
     */
    private $sugarcrm;

    /**
     * @var File
     */
    private $file;

    /**
     * @var Manager
     */
    private $dataManager;

    /**
     * GenerateSpecCommand constructor.
     *
     * @param null      $name
     * @param Generator $generator
     * @param Manager   $dataManager
     */
    public function __construct($name, Generator $generator, Manager $dataManager)
    {
        parent::__construct($name);

        $this->generator = $generator;
        $this->dataManager = $dataManager;
        $this->sugarcrm = new Sugarcrm();
        $this->file = new File();
    }

    /**
     *  Configure the command.
     */
    protected function configure()
    {
        $this->setName('generate:spec')
            ->setDescription('Generate a new upgrade spec')
            ->addArgument('path', InputArgument::REQUIRED, 'Path to SugarCRM build we are going to upgrade')
            ->addArgument('version', InputArgument::OPTIONAL, 'Version to upgrade to')
            ->addOption('dump', 'D', InputOption::VALUE_NONE, 'Save generated spec to file')
            ->addOption('upgradeSource', 'U', InputOption::VALUE_OPTIONAL, 'Path to a folder with SugarCRM upgrade packages');
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
        $path = $input->getArgument('path');

        $version = $this->sugarcrm->getBuildVersion($path);
        $flav = $this->sugarcrm->getBuildFlav($path);
        $targetVersion = $input->getArgument('version') ? new Version($input->getArgument('version')) : null;
        $upgradeTo = $this->dataManager->getLatestVersion($flav, $targetVersion);

        $upgradeSource = null;
        if ($input->hasParameterOption('--upgradeSource') || $input->hasParameterOption('-U')) {
            $upgradeSource = $input->getOption('upgradeSource');
            if (!file_exists($upgradeSource) || !is_readable($upgradeSource)) {
                throw new \InvalidArgumentException('Invalid "upgradePackages" argument value');
            }
        }

        $upgradeContext = new Upgrade(
            new Build($version, $flav, $path),
            new Target($upgradeTo, $flav, $upgradeSource)
        );

        $output->writeln(sprintf('<comment>Generating upgrade spec: %s ...</comment>', $upgradeContext));

        $spec = $this->generator->generate($upgradeContext);

        if ($input->hasParameterOption('--dump') || $input->hasParameterOption('-D')) {
            $this->file->saveToFile(sprintf('%s.md', $upgradeContext->asFilename()), $spec);
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
        $version = $input->getArgument('version') ? new Version($input->getArgument('version')) : null;

        $this->validatePath($path);
        $this->validateVersion(
            $this->sugarcrm->getBuildVersion($path),
            $this->dataManager->getLatestVersion($this->sugarcrm->getBuildFlav($path), $version)
        );
    }

    /**
     * @param $path
     */
    private function validatePath($path)
    {
        if (!$this->sugarcrm->isSugarcrmBuild($path)) {
            throw new \InvalidArgumentException('Invalid "path" argument value');
        }
    }

    /**
     * @param Version $from
     * @param Version $to
     */
    private function validateVersion(Version $from, Version $to)
    {
        if (version_compare((string) $to->getFull(), (string) $from->getFull(), '<=')) {
            throw new \InvalidArgumentException(sprintf('Given version ("%s") is lower or equal to the build version ("%s")', $to, $from));
        }
    }
}
