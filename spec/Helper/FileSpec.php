<?php

namespace spec\Sugarcrm\UpgradeSpec\Helper;

use PhpSpec\Exception\Example\FailureException;
use Sugarcrm\UpgradeSpec\Helper\File;
use PhpSpec\ObjectBehavior;

class FileSpec extends ObjectBehavior
{
    /**
     * @var
     */
    private $filename;

    function let()
    {
        $this->filename = sys_get_temp_dir() . '/.uspec_filespec';
    }

    function letGo()
    {
        @unlink($this->filename);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(File::class);
    }

    function it_saves_content_to_file()
    {
        $data = 'aaa';
        $this->saveToFile($this->filename, $data)->shouldSaveData($data);
    }

    public function getMatchers()
    {
        return [
            'saveData' => function ($subject, $expected) {
                $contents = file_get_contents($this->filename);
                if ($expected !== $contents) {
                    throw new FailureException(sprintf(
                        'Expected file contents are "%s", got "%s"',
                        $expected, $contents
                    ));
                }

                return true;
            },
        ];
    }
}
