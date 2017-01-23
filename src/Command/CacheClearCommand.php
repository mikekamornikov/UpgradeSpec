<?php

namespace Sugarcrm\UpgradeSpec\Command;

use Sugarcrm\UpgradeSpec\Cache\Cache;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CacheClearCommand extends Command
{
    /**
     * @var Cache
     */
    private $cache;

    /**
     * CacheCleanCommand constructor.
     *
     * @param null  $name
     * @param Cache $cache
     */
    public function __construct($name, Cache $cache)
    {
        parent::__construct($name);

        $this->cache = $cache;
    }

    /**
     * Configure the command.
     */
    protected function configure()
    {
        $this->setName('cache:clear')
            ->setDescription('Clears uspec cache');
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
        $output->writeln('<comment>Cleaning application cache ...</comment>');
        $this->cache->clear();
        $output->writeln('<comment>Done</comment>');

        return 0;
    }
}
