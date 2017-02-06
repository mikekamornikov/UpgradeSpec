<?php

namespace Sugarcrm\UpgradeSpec\Data\Provider\SourceCode;

use Sugarcrm\UpgradeSpec\Data\Exception\WrongProviderException;
use Sugarcrm\UpgradeSpec\Context\Upgrade;

class LocalGitRepository implements SourceCodeProviderInterface
{
    /**
     * Gets the list of potentially broken customizations (changed and deleted files)
     *
     * @param Upgrade $context
     *
     * @return mixed
     * @throws WrongProviderException
     */
    public function getPotentiallyBrokenCustomizations(Upgrade $context)
    {
        throw new WrongProviderException('Not implemented');
    }

    /**
     * Gets the lists of upgrade steps for the given source
     *
     * @param Upgrade $context
     *
     * @return mixed
     * @throws WrongProviderException
     */
    public function getUpgradeSteps(Upgrade $context)
    {
        throw new WrongProviderException('Not implemented');
    }
}
