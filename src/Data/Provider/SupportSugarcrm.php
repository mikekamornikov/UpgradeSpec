<?php

namespace Sugarcrm\UpgradeSpec\Data\Provider;

use GuzzleHttp\Client;
use League\HTMLToMarkdown\HtmlConverter;
use Sugarcrm\UpgradeSpec\Cache\Cache;
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
        $this->httpClient = new Client(['base_uri' => 'http://support.sugarcrm.com']);
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
     * Get feature enhancements for all available versions from given range
     * @param array $versions
     * @return mixed
     */
    public function getFeatureEnhancements(array $versions)
    {
        return $this->getReleaseNotes($versions, '#Feature_Enhancements');
    }

    /**
     * Get development changes for all available versions from given range
     * @param array $versions
     * @return mixed
     */
    public function getDevelopmentChanges(array $versions)
    {
        return $this->getReleaseNotes($versions, '#Development_Changes');
    }

    /**
     * @param $versions
     * @param $domPath
     * @return array
     */
    private function getReleaseNotes($versions, $domPath)
    {
        $cacheKey = $this->getCacheKey($domPath);

        $releaseNotes = [];
        foreach ($versions as $version) {

            $versionKey = $cacheKey . '_' . $version;
            if ($this->cache->has($versionKey)) {
                $releaseNotes[] = $this->cache->get($versionKey);
            }

            $delimiter = '.';
            list($v1, $v2) = explode($delimiter, $version);

            $major = implode($delimiter, [$v1, $v2]);
            $url = sprintf('/Documentation/Sugar_Versions/%s/Ult/Sugar_%s_Release_Notes/index.html', $major, $version);
            $response = $this->httpClient->request('GET', $url);
            $crawler = new Crawler($response->getBody()->getContents());

            $releaseNote = [];
            $nodes = $crawler->filter($domPath);
            if (count($nodes)) {
                $nextSiblings = $nodes->nextAll();
                if (count($p = $nextSiblings->filter('p'))) {
                    $releaseNote[] = '<p>' . $p->first()->html() . '</p>';
                }
                if (count($ul = $nextSiblings->filter('ul'))) {
                    $releaseNote[] = '<ul>' . $ul->first()->html() . '</ul>';
                }

                if ($releaseNote) {
                    $releaseNote = $this->htmlConverter->convert(implode('<br>', $releaseNote));

                    $this->cache->set($versionKey, $releaseNote);

                    $releaseNotes[] = $releaseNote;
                }
            }
        }

        return $releaseNotes;
    }

    /**
     * Return string which can be used as cache key
     * @param $key
     * @return mixed
     */
    private function getCacheKey($key)
    {
        return preg_replace('/[^a-zA-Z0-9_\.]+/', '', strtolower($key));
    }
}
