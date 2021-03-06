<?php

namespace spec\Sugarcrm\UpgradeSpec\Data;

use Sugarcrm\UpgradeSpec\Context\Target;
use Sugarcrm\UpgradeSpec\Context\TestBuild;
use Sugarcrm\UpgradeSpec\Data\Manager;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Sugarcrm\UpgradeSpec\Data\Provider\Memory;
use Sugarcrm\UpgradeSpec\Data\ProviderChain;
use Sugarcrm\UpgradeSpec\Context\Upgrade;
use Sugarcrm\UpgradeSpec\Version\OrderedList;
use Sugarcrm\UpgradeSpec\Version\Version;

class ManagerSpec extends ObjectBehavior
{
    /**
     * @var string
     */
    private $flav = 'ult';

    /**
     * @var array
     */
    private $data = [];

    function let()
    {
        $this->flav = 'ult';
        $this->data = [
            $this->flav . '_versions' => ['7.6.2.0', '7.6.2.2', '7.7.1', '7.7.2', '7.7.3', '7.8.0.0'],
            $this->flav . '_7.6.2.0_release_notes' => 'rn7620',
            $this->flav . '_7.7.1_release_notes' => 'rn771',
            $this->flav . '_7.7.2_release_notes' => 'rn772',
            $this->flav . '_7.7.3_release_notes' => 'rn773',
            '7.7_health_check' => 'hc77',
            '7.7_upgrader' => 'u77',
        ];

        $this->beConstructedWith(new ProviderChain([new Memory($this->data)]));
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Manager::class);
    }

    function it_gets_available_versions()
    {
        $this->getVersions($this->flav)->shouldReturnRange(new OrderedList(['7.6.2.0', '7.6.2.2', '7.7.1', '7.7.2', '7.7.3', '7.8.0.0']));
    }

    function it_throws_exception_if_no_versions_available()
    {
        $this->beConstructedWith(new ProviderChain([new Memory([])]));
        $this->shouldThrow(\RuntimeException::class)->during('getVersions', [$this->flav]);
    }

    function it_calculates_the_latest_available_version()
    {
        $this->getLatestVersion($this->flav)->shouldReturnVersion(new Version('7.8.0.0'));
        $this->getLatestVersion($this->flav, new Version('7.8'))->shouldReturnVersion(new Version('7.8.0.0'));
        $this->getLatestVersion($this->flav, new Version('7.8.0'))->shouldReturnVersion(new Version('7.8.0.0'));
        $this->getLatestVersion($this->flav, new Version('7.6'))->shouldReturnVersion(new Version('7.6.2.2'));
        $this->getLatestVersion($this->flav, new Version('7.7'))->shouldReturnVersion(new Version('7.7.3'));
        $this->getLatestVersion($this->flav, new Version('7.7.2'))->shouldReturnVersion(new Version('7.7.2'));
    }

    function it_throws_exception_if_given_version_is_not_available()
    {
        $this->shouldThrow(\InvalidArgumentException::class)->during('getLatestVersion', [$this->flav, new Version('7.6.2.3')]);
    }

    function it_throws_exception_if_no_minor_versions_available()
    {
        $this->shouldThrow(\InvalidArgumentException::class)->during('getLatestVersion', [$this->flav, new Version('7.5')]);
        $this->shouldThrow(\InvalidArgumentException::class)->during('getLatestVersion', [$this->flav, new Version('7.9')]);
        $this->shouldThrow(\InvalidArgumentException::class)->during('getLatestVersion', [$this->flav, new Version('7.7.4')]);
    }

    function it_gets_release_notes_for_given_upgrade_context()
    {
        $context = new Upgrade(
            new TestBuild(new Version('7.6.1'), $this->flav, '/path/to/build'),
            new Target(new Version('7.7.3'), $this->flav, '/path/to/upgrade/packages')
        );
        $this->getReleaseNotes($context)->shouldReturn([
            '7.6.2.0' => 'rn7620',
            '7.6.2.2' => '',
            '7.7.1' => 'rn771',
            '7.7.2' => 'rn772',
            '7.7.3' => 'rn773',
        ]);

        $context = new Upgrade(
            new TestBuild(new Version('7.7.1'), $this->flav, '/path/to/build'),
            new Target(new Version('7.7.3'), $this->flav, '/path/to/upgrade/packages')
        );
        $this->getReleaseNotes($context)->shouldReturn([
            '7.7.2' => 'rn772',
            '7.7.3' => 'rn773',
        ]);
    }

    function it_gets_health_check_info()
    {
        $this->getHealthCheckInfo(new Version('7.6'))->shouldReturn('');
        $this->getHealthCheckInfo(new Version('7.7'))->shouldReturn('hc77');
    }

    function it_gets_upgrader_info()
    {
        $this->getUpgraderInfo(new Version('7.6'))->shouldReturn('');
        $this->getUpgraderInfo(new Version('7.7'))->shouldReturn('u77');
    }

    public function getMatchers()
    {
        return [
            'returnVersion' => function(Version $subject, Version $key) {
                return $subject->isEqualTo($key, true);
            },
            'returnRange' => function(OrderedList $subject, OrderedList $key) {
                return (string) $subject == (string) $key;
            }
        ];
    }
}
