<?php

namespace spec\Sugarcrm\UpgradeSpec\Command;

use Sugarcrm\UpgradeSpec\Cache\Cache;
use Sugarcrm\UpgradeSpec\Command\CacheClearCommand;
use PhpSpec\ObjectBehavior;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CacheClearCommandSpec extends ObjectBehavior
{
    function let(Cache $cache)
    {
        $this->beConstructedWith(null, $cache);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(CacheClearCommand::class);
    }

    function it_cleans_application_cache(InputInterface $input, OutputInterface $output, Cache $cache)
    {
        $cache->clear()->shouldBeCalled();

        $this->run($input, $output);

        $output->writeln('<comment>Done</comment>')->shouldHaveBeenCalled();
    }
}
