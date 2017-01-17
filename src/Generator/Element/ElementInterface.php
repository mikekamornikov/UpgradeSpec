<?php

namespace Sugarcrm\UpgradeSpec\Generator\Element;

interface ElementInterface
{
    public function getTitle();

    public function getBody();

    public function getOrder();

    public function isRelevantTo($version, $newVersion);
}
