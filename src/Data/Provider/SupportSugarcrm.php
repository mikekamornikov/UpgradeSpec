<?php

namespace Sugarcrm\UpgradeSpec\Data\Provider;

use GuzzleHttp\Client;
use GuzzleHttp\Pool;
use League\HTMLToMarkdown\HtmlConverter;
use Sugarcrm\UpgradeSpec\Cache\Cache;
use Sugarcrm\UpgradeSpec\Purifier\Html;
use Symfony\Component\DomCrawler\Crawler;

class SupportSugarcrm implements ProviderInterface
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
     * @param Cache $cache
     * @param HtmlConverter $htmlConverter
     */
    public function __construct(Cache $cache, HtmlConverter $htmlConverter)
    {
        $this->httpClient = new Client(['base_uri' => 'http://support.sugarcrm.com/']);
        $this->cache = $cache;
        $this->htmlConverter = $htmlConverter;
    }

    /**
     * Get all available SugarCRM versions (sorted ASC)
     * @return mixed
     */
    public function getVersions()
    {
        if ($this->cache->has('versions')) {
            return $this->cache->get('versions');
        }

        $response = $this->httpClient->request('GET', '/Documentation/Sugar_Versions/index.html');

        $crawler = new Crawler($response->getBody()->getContents());
        $majors = [];
        foreach ($crawler->filter('section.content-body > h1') as $node) {
            $major = $node->textContent;
            if (preg_match('/^\d+\.\d+$/', $major)) {
                $majors[] = $major;
            }
        }

        $versions = [];
        foreach ($majors as $major) {
            $url = sprintf('/Documentation/Sugar_Versions/%s/Ult/index.html', $major);
            $response = $this->httpClient->request('GET', $url);

            $crawler = new Crawler($response->getBody()->getContents());
            foreach ($crawler->filter('#Release_Notes')->first()->nextAll()->filter('a') as $node) {
                if (preg_match_all('/\d+(\.\d+){1,3}/', $node->textContent, $match)) {
                    $versions[] = $match[0][0];
                }
            }
        }

        // sort versions (ASC)
        usort($versions, function ($v1, $v2) {
            return version_compare($v1, $v2, '<') ? -1 : (version_compare($v1, $v2, '>') ? 1 : 0) ;
        });

        $this->cache->set('versions', $versions);

        return $versions;
    }

    /**
     * @param array $versions
     * @return array
     */
    public function getReleaseNotes(array $versions)
    {
        $newVersions = array_filter($versions, function ($version) {
            return !$this->cache->has($this->getCacheKey(['release_notes', $version]));
        });

        $requests = function () use ($newVersions) {
            foreach ($newVersions as $version) {
                yield $version => function () use ($version) {
                    return $this->httpClient->getAsync($this->getReleaseNotesUri($version));
                };
            }
        };

        if ($newVersions) {
            $this->processRequestPool($requests, [
                'fulfilled' => function ($response, $version) {

                    $base = dirname($this->httpClient->getConfig('base_uri') . ltrim($this->getReleaseNotesUri($version), '/')) . '/';
                    $crawler = new Crawler($this->purifyHtml($response->getBody()->getContents(), $base));

                    $identifiers = [
                        'feature_enhancements' => '#Feature_Enhancements',
                        'development_changes' => '#Development_Changes'
                    ];

                    $releaseNote = [];
                    foreach ($identifiers as $key => $identifier) {
                        $nodes = $crawler->filter($identifier);
                        if (count($nodes)) {
                            $nextSiblings = $nodes->nextAll();

                            $content = [];
                            if (count($p = $nextSiblings->filter('p'))) {
                                $content[] = '<p>' . $p->first()->html() . '</p>';
                            }
                            if (count($ul = $nextSiblings->filter('ul'))) {
                                $content[] = '<ul>' . $ul->first()->html() . '</ul>';
                            }

                            if ($content) {
                                $releaseNote[$key] = $this->htmlConverter->convert(implode('<br>', $content));
                            }
                        }
                    }

                    $this->cache->set($this->getCacheKey(['release_notes', $version]), $releaseNote);
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
            $releaseNote = $this->cache->get($this->getCacheKey(['release_notes', $version]), null);
            if ($releaseNote) {
                $releaseNotes[$version] = $releaseNote;
            }
        }

        uksort($releaseNotes, function ($v1, $v2) {
            return version_compare($v1, $v2, '<') ? -1 : (version_compare($v1, $v2, '>') ? 1 : 0) ;
        });

        return $releaseNotes;
    }

    /**
     * Returns version specific release note uri
     * @param $version
     * @return string
     */
    private function getReleaseNotesUri($version)
    {
        list($v1, $v2) = explode('.', $version);
        $major = implode('.', [$v1, $v2]);

        return sprintf('/Documentation/Sugar_Versions/%s/Ult/Sugar_%s_Release_Notes/index.html', $major, $version);
    }

    /**
     * Returns cache key
     * @param $keyParts
     * @return mixed
     */
    private function getCacheKey(array $keyParts)
    {
        $delimiter = '___';

        return implode($delimiter, array_map(function ($key) {
            return preg_replace('/[^a-zA-Z0-9_\.]+/', '', strtolower($key));
        }, $keyParts));
    }

    /**
     * Lightweight HTML purifier
     * @param $html
     * @param null $baseUrl
     * @param array $options
     * @return mixed
     */
    private function purifyHtml($html, $baseUrl = null, $options = [])
    {
        $options = array_merge([
            'absolute_urls' => true,
            'no_tag_duplicates' => true,
            'pre_to_code' => true,
        ], $options);

        return (new Html($baseUrl, $options))->purify($html);
    }

    /**
     * Processes request pool
     * @param callable $requests
     * @param array $config
     * @return mixed
     */
    private function processRequestPool(callable $requests, $config = [])
    {
        /**
         * 1. create request pool
         * 2. initiate the transfers and create a promise
         * 3. force the pool of requests to complete
         */
        return (new Pool($this->httpClient, $requests(), $config))->promise()->wait();
    }
}
