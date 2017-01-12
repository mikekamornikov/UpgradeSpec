<?php

namespace Sugarcrm\UpgradeSpec\Generator\SpecElement;

interface SpecElementInterface
{
    public function getTitle();

    public function getBody();

    public function getOrder();

    public function isRelevantTo($version);
}
