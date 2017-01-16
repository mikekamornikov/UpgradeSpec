<?php

namespace Sugarcrm\UpgradeSpec\Generator\SpecElement;

class CoreChanges implements SpecElementInterface
{
    /**
     * @return string
     */
    public function getTitle()
    {
        return 'Backup or rewrite core changes';
    }

    /**
     * @return int
     */
    public function getOrder()
    {
        return 1;
    }

    /**
     * @param $version
     * @return bool
     */
    public function isRelevantTo($version)
    {
        return true;
    }

    /**
     * @return string
     */
    public function getBody()
    {
        $body = <<<EOF
If your build sources are GIT driven ("sugarcrm/Mango" fork) find all your core changes and (if possible) rewrite them in upgrade safe way. This way you'll avoid merge conflicts during the upgrade.
If it's not possible be sure to track and backup such changes. There is a big chance some of them:
- are implemented by core dev team in the version you plan to upgrade to
- make no sense anymore
- cause additional issues on its own (for example require missing file)
EOF;

        return $body;
    }
}
