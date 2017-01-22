<?php

namespace Sugarcrm\UpgradeSpec\Data\Provider;

use GuzzleHttp\Client;
use GuzzleHttp\Pool;
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
                    $crawler = new Crawler($this->purifyHtml($response->getBody()->getContents(), $base, [
                        'absolute_urls', 'remove_tag_duplicates', 'pre_to_code'
                    ]));

                    $identifiers = [
                        'features' => '#Feature_Enhancements',
                        'dev_changes' => '#Development_Changes'
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
     * Returns version specific release notes uri
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
     * Converts all relative links (@href) to absolute ones
     * @param $content
     * @param $base
     * @return mixed
     */
    private function convertLinks($content, $base)
    {
        // href pattern
        $pattern = '/(?<=href=("|\'))[^"\']+(?=("|\'))/';

        $host = parse_url($base, PHP_URL_HOST);
        $path = parse_url($base, PHP_URL_PATH);
        $scheme = parse_url($base, PHP_URL_SCHEME);

        return preg_replace_callback($pattern, function ($matches) use ($base, $scheme, $host, $path) {

            $hrefValue = $matches[0];

            if (strpos($hrefValue, '//') === 0) {
                return $scheme . ':' . $hrefValue;
            }

            // return if already absolute URL
            if  (parse_url($hrefValue, PHP_URL_SCHEME) != '') {
                return $hrefValue;
            }

            // queries and anchors
            if ($hrefValue[0] == '#' || $hrefValue[0] == '?') {
                return $base . $hrefValue;
            }

            // remove non-directory element from path
            $path = preg_replace('#/[^/]*$#', '', $path);

            // destroy path if relative url points to root
            if ($hrefValue[0] ==  '/') {
                $path = '';
            }

            // dirty absolute URL
            $abs = $host . $path . '/' .$hrefValue;

            // replace '//', '/./', '/foo/../' with '/'
            $abs = preg_replace('/\/[^\/]+\/\.\.\//', '/', str_replace(['//', '/./'], '/', $abs));

            // absolute URL is ready
            return  $scheme . '://' . $abs;
        }, $content);
    }

    /**
     * Removes duplicated tags
     * @param $content
     * @return mixed
     */
    private function removeTagDuplicates($content)
    {
        // strong -> b
        $content = str_replace(['<strong>', '</strong>'], ['<b>', '</b>'], $content);

        // unite duplicates
        $content = preg_replace('/(<\/b>\s*)+/', '</b> ', preg_replace('/(<b>\s*)+/', '<b>', $content));

        // cleanup
        return preg_replace('/(<\/b>\s*<b>)+/', ' ', $content);
    }

    /**
     * Converts "pre" to "code"
     * @param $content
     * @return mixed
     */
    private function convertCode($content)
    {
        // strpos with array support
        $strposa = function ($haystack, $needles = []) {
            $chr = [];
            foreach ($needles as $needle) {
                $res = strpos($haystack, $needle);
                if ($res !== false) {
                    $chr[$needle] = $res;
                }
            }

            if (empty($chr)) {
                return false;
            }

            return min($chr);
        };

        $content = str_replace(['<pre>', '<pre ', '</pre>'], ['<code>', '<code ', '</code>'], $content);

        return preg_replace_callback('/<code(.*?)>(.*?)<\/code>/s', function ($matches) use ($strposa) {
            $code = str_replace(
                ['<br></br>', '<br>', '<br/>', '&nbsp;'],
                [PHP_EOL, PHP_EOL, PHP_EOL, ' '],
                $matches[0]
            );

            // if multiline or real code snippet
            if (false !== $strposa($code, ['function', 'class', 'array'])
                || false !== strpos($code, PHP_EOL)) {
                return '<br/>' . $code;
            }

            return $code;
        }, $content);
    }

    /**
     * @param $html
     * @param null $baseUrl
     * @param array $options
     * @return mixed
     */
    private function purifyHtml($html, $baseUrl = null, $options = [])
    {
        if (in_array('absolute_urls', $options)) {
            $html = $this->convertLinks($html, $baseUrl);
        }

        if (in_array('remove_tag_duplicates', $options)) {
            $html = $this->removeTagDuplicates($html);
        }

        if (in_array('pre_to_code', $options)) {
            $html = $this->convertCode($html);
        }

        return $html;
    }

    /**
     * Processes request pool
     * @param callable $requests
     * @param array $config
     */
    private function processRequestPool(callable $requests, $config = [])
    {
        /**
         * 1. create request pool
         * 2. initiate the transfers and create a promise
         * 3. force the pool of requests to complete
         */
        (new Pool($this->httpClient, $requests(), $config))->promise()->wait();
    }
}
