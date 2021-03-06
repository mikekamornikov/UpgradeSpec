<?php

namespace Sugarcrm\UpgradeSpec\Formatter;

class MarkdownFormatter implements FormatterInterface
{
    /**
     * @param $text
     * @param int $level
     *
     * @return string
     */
    public function asTitle($text, $level = 1)
    {
        return str_repeat('#', $level) . ' ' . ucfirst($text);
    }

    /**
     * @param $text
     *
     * @return string
     */
    public function asBody($text)
    {
        return $text;
    }

    /**
     * @return string
     */
    public function getDelimiter()
    {
        return PHP_EOL . PHP_EOL;
    }
}
