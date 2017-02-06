<?php

namespace Sugarcrm\UpgradeSpec\Context;

use Sugarcrm\UpgradeSpec\Helper\Sugarcrm;
use Sugarcrm\UpgradeSpec\Version\Version;

class Build extends Metadata
{
    /**
     * Build constructor.
     *
     * @param $version
     * @param $flav
     * @param string $source
     */
    public function __construct(Version $version, $flav, $source)
    {
        $this->validateSource($source);

        parent::__construct($version, $flav, $source);
    }

    /**
     * @param $source
     */
    protected function validateSource($source)
    {
        $helper = new Sugarcrm();
        if (!$helper->isSugarcrmBuild($source)) {
            throw new \InvalidArgumentException(sprintf('"%s" is not a valid SugarCRM build', $source));
        }
    }
}
