<?php

namespace Sugarcrm\UpgradeSpec\Data\Provider\SourceCode;

use Sugarcrm\UpgradeSpec\Data\Provider\ProviderInterface;
use Sugarcrm\UpgradeSpec\Context\Upgrade;

interface SourceCodeProviderInterface extends ProviderInterface
{
    /**
     * Gets the list of potentially broken customizations (changed and deleted files)
     *
     * @param Upgrade $context
     *
     * @return mixed
     */
    public function getPotentiallyBrokenCustomizations(Upgrade $context);

    /**
     * Gets the lists of upgrade steps for the given source
     *
     * @param Upgrade $context
     *
     * @return mixed
     */
    public function getUpgradeSteps(Upgrade $context);
}
