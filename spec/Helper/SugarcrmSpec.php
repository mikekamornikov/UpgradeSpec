<?php

namespace spec\Sugarcrm\UpgradeSpec\Helper;

use Sugarcrm\UpgradeSpec\Helper\Sugarcrm;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Sugarcrm\UpgradeSpec\Version\Version;

class SugarcrmSpec extends ObjectBehavior
{
    /**
     * @var
     */
    private $path;

    function let()
    {
        $this->path = sys_get_temp_dir();

        $data = <<<'EOL'
<?php
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
$sugar_version      = '7.6.1';
$sugar_db_version   = '7.6.1';
$sugar_flavor       = 'ULT';
$sugar_build        = '999';
$sugar_timestamp    = '2008-08-01 12:00am';
EOL;


        file_put_contents($this->path. '/sugar_version.php', $data);
    }

    function letGo()
    {
        @unlink($this->path. '/sugar_version.php');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Sugarcrm::class);
    }

    function it_checks_if_path_is_a_valid_sugarcrm_build()
    {
        $this->isSugarcrmBuild($this->path)->shouldBe(true);

        @unlink($this->path. '/sugar_version.php');
        $this->isSugarcrmBuild($this->path)->shouldBe(false);
    }

    function it_gets_build_version()
    {
        $this->getBuildVersion($this->path)->shouldReturnVersion(new Version('7.6.1'));
    }

    function it_gets_build_flav()
    {
        $this->getBuildFlav($this->path)->shouldReturn('ULT');
    }

    public function getMatchers()
    {
        return [
            'returnVersion' => function(Version $subject, Version $key) {
                return $subject->isEqualTo($key, true);
            },
        ];
    }
}
