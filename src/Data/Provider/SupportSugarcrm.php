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

        //
        usort($versions, function ($v1, $v2) {
            return version_compare($v1, $v2, '<') ? -1 : (version_compare($v1, $v2, '>') ? 1 : 0) ;
        });

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
        $releaseNotes = [];
        foreach ($versions as $version) {
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
                    $releaseNotes[] = $this->htmlConverter->convert(implode('<br>', $releaseNote));
                }
            }
        }

        return $releaseNotes;
    }
}
