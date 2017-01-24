<?php

namespace Sugarcrm\UpgradeSpec\Element;

use Sugarcrm\UpgradeSpec\Spec\Context;

interface ElementInterface
{
    public function getTitle();

    public function getBody(Context $context);

    public function getOrder();

    public static function isRelevantTo(Context $context);
}
