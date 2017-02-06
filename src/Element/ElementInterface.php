<?php

namespace Sugarcrm\UpgradeSpec\Element;

use Sugarcrm\UpgradeSpec\Context\Upgrade;

interface ElementInterface
{
    /**
     * @return string
     */
    public function getTitle();

    /**
     * @param Upgrade $context
     *
     * @return mixed
     */
    public function getBody(Upgrade $context);

    /**
     * @return mixed
     */
    public function getOrder();

    /**
     * @param Upgrade $context
     *
     * @return bool
     */
    public function isRelevantTo(Upgrade $context);
}
