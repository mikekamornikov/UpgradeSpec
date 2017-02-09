<?php

namespace Sugarcrm\UpgradeSpec\Data\Provider\Doc;

use GuzzleHttp\Client;
use GuzzleHttp\Pool;
use League\HTMLToMarkdown\HtmlConverter;
use Psr\Http\Message\ResponseInterface;
use Sugarcrm\UpgradeSpec\Cache\Cache;
use Sugarcrm\UpgradeSpec\Purifier\Html;
use Sugarcrm\UpgradeSpec\Version\OrderedList;
use Sugarcrm\UpgradeSpec\Version\Version;
use Symfony\Component\DomCrawler\Crawler;

class SupportSugarcrm implements DocProviderInterface
{
    /**
     * @var Client
     */
    private $httpClient;

    /**
     * @var Cache
     */
    private $cache;

    /**
     * @var HtmlConverter
     */
    private $htmlConverter;

    /**
     * SupportSugarcrm constructor.
     *
     * @param Cache         $cache
     * @param HtmlConverter $htmlConverter
     */
    public function __construct(Cache $cache, HtmlConverter $htmlConverter)
    {
        $this->httpClient = new Client(['base_uri' => 'http://support.sugarcrm.com/']);
        $this->cache = $cache;
        $this->htmlConverter = $htmlConverter;
    }

    /**
     * Get all available SugarCRM versions (sorted ASC).
     *
     * @param string $flav
     *
     * @return OrderedList
     */
    public function getVersions($flav)
    {
        if ($this->cache->has($this->getCacheKey([$flav, 'versions']))) {
            return $this->cache->get($this->getCacheKey([$flav, 'versions']));
        }

        $crawler = new Crawler($this->getContent('/Documentation/Sugar_Versions/index.html'));
        $majorReleases = [];
        foreach ($crawler->filter('section.content-body > h1') as $node) {
            $majorRelease = $node->textContent;
            if (preg_match('/^\d+\.\d+$/', $majorRelease)) {
                $majorReleases[] = $majorRelease;
            }
        }

        $versions = [];
        foreach (new OrderedList($majorReleases) as $version) {
            $crawler = new Crawler($this->getContent($this->getVersionUri($flav, $version)));
            foreach ($crawler->filter('#Release_Notes')->first()->nextAll()->filter('a') as $node) {
                if (preg_match_all('/\d+(\.\d+){1,3}/', $node->textContent, $match)) {
                    $versions[] = $match[0][0];
                }
            }
        }

        $versions = new OrderedList($versions);
        $this->cache->set($this->getCacheKey([$flav, 'versions']), $versions);

        return $versions;
    }

    /**
     * @param string $flav
     * @param OrderedList $versions
     *
     * @return array
     */
    public function getReleaseNotes($flav, OrderedList $versions)
    {
        $newVersions = $versions->filter(function (Version $version) use ($flav) {
            return !$this->cache->has($this->getCacheKey([$flav, 'release_notes', (string) $version]));
        });

        $requests = function () use ($flav, $newVersions) {
            foreach ($newVersions as $version) {
                yield (string) $version => function () use ($flav, $version) {
                    return $this->httpClient->getAsync($this->getReleaseNotesUri($flav, $version));
                };
            }
        };

        if (count($newVersions)) {
            $this->processRequestPool($requests, [
                'fulfilled' => function (ResponseInterface $response, $version) use ($flav) {
                    $html = $response->getBody()->getContents();
                    $crawler = new Crawler($this->purifyHtml($html, $this->getReleaseNotesUri($flav, new Version($version))));

                    $identifiers = [
                        'feature_enhancements' => '#Feature_Enhancements',
                        'development_changes' => '#Development_Changes',
                    ];

                    $releaseNote = [];
                    foreach ($identifiers as $key => $identifier) {
                        $nodes = $crawler->filter($identifier);
                        if (count($nodes)) {
                            $nextSiblings = $nodes->nextAll();

                            $content = [];
                            foreach (['p', 'ul'] as $tag) {
                                if (count($filtered = $nextSiblings->filter($tag))) {
                                    $content[] = sprintf('<%1$s>%2$s</%1$s>', $tag, $filtered->first()->html());
                                }
                            }

                            if ($content) {
                                $releaseNote[$key] = $this->htmlConverter->convert(implode('<br>', $content));
                            }
                        }
                    }

                    $this->cache->set($this->getCacheKey([$flav, 'release_notes', $version]), $releaseNote);
                },
                'rejected' => function ($reason, $version) {
                    throw new \RuntimeException(
                        sprintf('Can\'t get release notes for version: %s (reason: %s)', $version, $reason)
                    );
                },
            ]);
        }

        $releaseNotes = [];
        foreach ($versions as $version) {
            $releaseNote = $this->cache->get($this->getCacheKey([$flav, 'release_notes', (string) $version]), null);
            if ($releaseNote) {
                $releaseNotes[(string) $version] = $releaseNote;
            }
        }

//        uksort($releaseNotes, function ($v1, $v2) {
//            return version_compare($v1, $v2, '<') ? -1 : (version_compare($v1, $v2, '>') ? 1 : 0);
//        });

        return $releaseNotes;
    }

    /**
     * Gets all required information to perform health check.
     *
     * @param Version $version
     *
     * @return mixed
     */
    public function getHealthCheckInfo(Version $version)
    {
        $version = $version->getMajor();
        $cacheKey = $this->getCacheKey(['health_check', (string) $version]);

        if ($this->cache->has($cacheKey)) {
            return $this->cache->get($cacheKey);
        }

        $url = $this->getHealthCheckInfoUri($version);
        $crawler = new Crawler($this->purifyHtml($this->getContent($url), $url));

        $infoNode = $crawler->filter('#Performing_the_Health_Check_2')->nextAll()->first();
        $info = str_replace(['**<', '>**'], '**', $this->htmlConverter->convert($infoNode->html()));

        $this->cache->set($cacheKey, $info);

        return $info;
    }

    /**
     * Gets all required information to perform upgrade.
     *
     * @param Version $version
     *
     * @return mixed
     */
    public function getUpgraderInfo(Version $version)
    {
        $version = $version->getMajor();
        $cacheKey = $this->getCacheKey(['upgrader', (string) $version]);

        if ($this->cache->has($cacheKey)) {
            return $this->cache->get($cacheKey);
        }

        $url = $this->getUpgraderInfoUri($version);
        $crawler = new Crawler($this->purifyHtml($this->getContent($url), $url));

        $id = $version->isEqualTo(new Version('6.5')) ? '#Upgrading_Via_Silent_Upgrader' : '#Performing_the_Upgrade_2';
        $nodes = $crawler->filter($id)->nextAll();

        $content = [];
        foreach (['ol', 'p'] as $tag) {
            if (count($filtered = $nodes->filter($tag))) {
                $content[] = sprintf('<%1$s>%2$s</%1$s>', $tag, $filtered->first()->html());
            }
        }

        $info = str_replace(['**<', '>**'], '**', $this->htmlConverter->convert(implode('<br>', $content)));

        $this->cache->set($cacheKey, $info);

        return $info;
    }

    /**
     * Returns the result (response body) of GET request.
     *
     * @param string $url
     *
     * @return string
     */
    private function getContent($url)
    {
        $response = $this->httpClient->request('GET', $url);

        return $response->getBody()->getContents();
    }

    /**
     * @param Version $version
     *
     * @return string
     */
    private function getHealthCheckInfoUri(Version $version)
    {
        return $this->getUpgradeGuideUri($version);
    }

    /**
     * @param Version $version
     *
     * @return string
     */
    private function getUpgraderInfoUri(Version $version)
    {
        return $this->getUpgradeGuideUri($version);
    }

    /**
     * @param Version $version
     *
     * @return string
     */
    private function getUpgradeGuideUri(Version $version)
    {
        return sprintf(
            'Documentation/Sugar_Versions/%s/Ult/Installation_and_Upgrade_Guide/index.html',
            $version
        );
    }

    /**
     * @param string $flav
     * @param Version $version
     *
     * @return string
     */
    private function getVersionUri($flav, Version $version)
    {
        $flav = ucfirst(mb_strtolower($flav));

        return sprintf('/Documentation/Sugar_Versions/%s/%s/index.html', $version, $flav);
    }

    /**
     * Returns version specific release note uri.
     *
     * @param string $flav
     * @param Version $version
     *
     * @return string
     */
    private function getReleaseNotesUri($flav, Version $version)
    {
        return sprintf(
            '/Documentation/Sugar_Versions/%s/%s/Sugar_%s_Release_Notes/index.html',
            $version->getMajor(),
            ucfirst(mb_strtolower($flav)),
            $version
        );
    }

    /**
     * Returns cache key.
     *
     * @param $keyParts
     *
     * @return string
     */
    private function getCacheKey(array $keyParts)
    {
        $delimiter = '___';

        return implode($delimiter, array_map(function ($key) {
            return preg_replace('/[^a-zA-Z0-9_\.]+/', '', mb_strtolower($key));
        }, $keyParts));
    }

    /**
     * Lightweight HTML purifier.
     *
     * @param $html
     * @param string $url
     * @param array  $options
     *
     * @return string
     */
    private function purifyHtml($html, $url = '', $options = [])
    {
        $baseUrl = rtrim($this->httpClient->getConfig('base_uri'), '/') . '/';
        if ($url) {
            $baseUrl = dirname($baseUrl . ltrim($url, '/')) . '/';
        }

        $options = array_merge([
            'absolute_urls' => true,
            'no_tag_duplicates' => true,
            'pre_to_code' => true,
        ], $options);

        return (new Html($baseUrl, $options))->purify($html);
    }

    /**
     * Processes request pool.
     *
     * @param callable $requests
     * @param array    $config
     *
     * @return mixed
     */
    private function processRequestPool(callable $requests, $config = [])
    {
        /*
         * 1. create request pool
         * 2. initiate the transfers and create a promise
         * 3. force the pool of requests to complete
         */
        return (new Pool($this->httpClient, $requests(), $config))->promise()->wait();
    }
}
