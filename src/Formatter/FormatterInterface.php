<?php

namespace Sugarcrm\UpgradeSpec\Formatter;

interface FormatterInterface
{
    public function asTitle($text, $level = 1);

    public function asBody($text);

    public function getDelimiter();
}
