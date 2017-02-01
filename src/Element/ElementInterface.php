<?php

namespace Sugarcrm\UpgradeSpec\Element;

use Sugarcrm\UpgradeSpec\Spec\Context;

interface ElementInterface
{
    /**
     * @return string
     */
    public function getTitle();

    /**
     * @param Context $context
     *
     * @return mixed
     */
    public function getBody(Context $context);

    /**
     * @return mixed
     */
    public function getOrder();

    /**
     * @param Context $context
     *
     * @return bool
     */
    public function isRelevantTo(Context $context);
}
