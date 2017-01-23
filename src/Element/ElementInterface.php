<?php

namespace Sugarcrm\UpgradeSpec\Element;

interface ElementInterface
{
    public function getTitle();

    public function getBody($version, $newVersion);

    public function getOrder();

    public static function isRelevantTo($version, $newVersion);
}
