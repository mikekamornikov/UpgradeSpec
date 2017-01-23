<?php

namespace Sugarcrm\UpgradeSpec\Purifier;

class Html implements PurifierInterface
{
    /**
     * @var string
     */
    private $baseUrl;

    /**
     * @var array
     */
    private $options;

    /**
     * Html constructor.
     *
     * @param string $baseUrl
     * @param array  $options
     */
    public function __construct($baseUrl = '', array $options = [])
    {
        $this->baseUrl = $baseUrl;

        $this->options = array_merge([
            'absolute_urls' => false,
            'no_tag_duplicates' => false,
            'pre_to_code' => false,
        ], $options);

        $this->validateOptions($baseUrl);
    }

    /**
     * Purifies html.
     *
     * @param $data
     *
     * @return mixed
     */
    public function purify($data)
    {
        if ($this->options['absolute_urls']) {
            $data = $this->convertLinks($data);
        }

        if ($this->options['no_tag_duplicates']) {
            $data = $this->removeTagDuplicates($data);
        }

        if ($this->options['pre_to_code']) {
            $data = $this->convertCode($data);
        }

        return $data;
    }

    /**
     * Validates options.
     */
    private function validateOptions()
    {
        if (empty($this->baseUrl) && $this->options['absolute_urls']) {
            throw new \InvalidArgumentException('"absolute_urls" requires not empty base url');
        }
    }

    /**
     * Converts all relative links (@href) to absolute ones.
     *
     * @param $content
     *
     * @return mixed
     */
    private function convertLinks($content)
    {
        // href pattern
        $pattern = '/(?<=href=("|\'))[^"\']+(?=("|\'))/';

        $base = $this->baseUrl;
        $host = parse_url($base, PHP_URL_HOST);
        $path = parse_url($base, PHP_URL_PATH);
        $scheme = parse_url($base, PHP_URL_SCHEME);

        return preg_replace_callback($pattern, function ($matches) use ($base, $scheme, $host, $path) {
            $hrefValue = $matches[0];

            if (mb_strpos($hrefValue, '//') === 0) {
                return $scheme . ':' . $hrefValue;
            }

            // return if already absolute URL
            if (parse_url($hrefValue, PHP_URL_SCHEME) != '') {
                return $hrefValue;
            }

            // queries and anchors
            if ($hrefValue[0] == '#' || $hrefValue[0] == '?') {
                return $base . $hrefValue;
            }

            // remove non-directory element from path
            $path = preg_replace('#/[^/]*$#', '', $path);

            // destroy path if relative url points to root
            if ($hrefValue[0] == '/') {
                $path = '';
            }

            // dirty absolute URL
            $abs = $host . $path . '/' . $hrefValue;

            // replace '//', '/./', '/foo/../' with '/'
            $abs = preg_replace('/\/[^\/]+\/\.\.\//', '/', str_replace(['//', '/./'], '/', $abs));

            // absolute URL is ready
            return  $scheme . '://' . $abs;
        }, $content);
    }

    /**
     * Removes duplicated tags.
     *
     * @param $content
     *
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
     * Converts "pre" to "code".
     *
     * @param $content
     *
     * @return mixed
     */
    private function convertCode($content)
    {
        // strpos with array support
        $strposa = function ($haystack, $needles = []) {
            $chr = [];
            foreach ($needles as $needle) {
                $res = mb_strpos($haystack, $needle);
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
            $noLineBreaks = str_replace(["\r\n", "\r", "\n"], '<br />', $matches[0]);
            $code = str_replace(['<br></br>', '<br>', '<br/>', '<br />'], PHP_EOL, $noLineBreaks);

            // if multiline or real code snippet
            if (false !== $strposa($code, ['function', 'class', 'array'])
                || false !== mb_strpos($code, PHP_EOL)) {
                return '<br />' . $code . '<br />';
            }

            return $code;
        }, $content);
    }
}
