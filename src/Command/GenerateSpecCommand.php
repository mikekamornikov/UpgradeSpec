<?php

namespace Sugarcrm\UpgradeSpec\Command;

use Sugarcrm\UpgradeSpec\Data\Manager;
use Sugarcrm\UpgradeSpec\Helper\File;
use Sugarcrm\UpgradeSpec\Helper\Sugarcrm;
use Sugarcrm\UpgradeSpec\Spec\Context;
use Sugarcrm\UpgradeSpec\Spec\Generator;
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
     * @param Sugarcrm  $sugarcrmHelper
     * @param File      $fileHelper
     */
    public function __construct($name, Generator $generator, Manager $dataManager, Sugarcrm $sugarcrmHelper, File $fileHelper)
    {
        parent::__construct($name);

        $this->generator = $generator;
        $this->dataManager = $dataManager;
        $this->sugarcrm = $sugarcrmHelper;
        $this->file = $fileHelper;
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
            ->addOption('dump', 'D', InputOption::VALUE_NONE, 'Save generated spec to file');
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

        $upgradeTo = $this->dataManager->getLatestVersion($flav, $input->getArgument('version'));

        $upgradeContext = new Context($version, $upgradeTo, $flav);

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
        $version = $input->getArgument('version');

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
     * @param $buildVersion
     * @param $upgradeTo
     */
    private function validateVersion($buildVersion, $upgradeTo)
    {
        $buildVersionParts = explode('.', $buildVersion);

        $fullVersion = $buildVersion;

        // v1.v2 -> v1.v2.0.0, v1.v2.v3 -> v1.v2.v3.0
        if (($versionLength = count($buildVersionParts)) < 4) {
            $fullVersion = implode('.', array_merge($buildVersionParts, array_fill(0, 4 - $versionLength, '0')));
        }

        if (!preg_match('/\d+(\.\d+){1,3}/', $upgradeTo)) {
            throw new \InvalidArgumentException('Invalid version format');
        }

        if (version_compare($fullVersion, $upgradeTo, '>=')) {
            throw new \InvalidArgumentException(sprintf('Given version ("%s") is lower or equal to the build version ("%s")', $upgradeTo, $buildVersion));
        }
    }
}
