<?php

namespace spec\Sugarcrm\UpgradeSpec\Data\Provider\Doc;

use League\HTMLToMarkdown\HtmlConverter;
use Sugarcrm\UpgradeSpec\Cache\Adapter\Memory;
use Sugarcrm\UpgradeSpec\Cache\Cache;
use Sugarcrm\UpgradeSpec\Data\Provider\Doc\DocProviderInterface;
use Sugarcrm\UpgradeSpec\Data\Provider\Doc\SupportSugarcrm;
use Sugarcrm\UpgradeSpec\Data\Provider\ProviderInterface;
use PhpSpec\ObjectBehavior;
use Sugarcrm\UpgradeSpec\Version\OrderedList;
use Sugarcrm\UpgradeSpec\Version\Version;

class SupportSugarcrmSpec extends ObjectBehavior
{
    /**
     * @var string
     */
    private $flav = 'ult';

    /**
     * @var array
     */
    private $data = [];

    /**
     * @var Cache
     */
    private $cache;

    /**
     * @var HtmlConverter
     */
    private $htmlConverter;

    function let()
    {
        $this->flav = 'ult';

        $this->data = [
            $this->flav . '___versions' => new OrderedList(['7.6.2.0', '7.6.2.2', '7.7.1', '7.7.2', '7.8.0.0']),
            $this->flav . '___release_notes___7.7.2' => 'rn772',
            $this->flav . '___release_notes___7.8.0.0' => 'rn7800',
            'health_check___7.7' => 'hc77',
            'upgrader___7.7' => 'u77',
        ];

        $this->cache = new Cache(new Memory($this->data));
        $this->htmlConverter = new HtmlConverter();

        $this->beConstructedWith($this->cache, $this->htmlConverter);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(SupportSugarcrm::class);
    }

    function it_is_provider()
    {
        $this->shouldHaveType(ProviderInterface::class);
    }

    function it_is_doc_provider()
    {
        $this->shouldHaveType(DocProviderInterface::class);
    }

    function it_uses_cache_if_possible()
    {
        $this->getVersions($this->flav)->shouldReturn($this->cache->get($this->flav . '___versions'));
        $this->getReleaseNotes($this->flav, new OrderedList(['7.7.2', '7.8.0.0']))->shouldReturn([
            '7.7.2' => 'rn772',
            '7.8.0.0' => 'rn7800',
        ]);
        $this->getHealthCheckInfo(new Version('7.7'))->shouldReturn('hc77');
        $this->getUpgraderInfo(new Version('7.7'))->shouldReturn('u77');
    }
}
