<?php

namespace Sugarcrm\UpgradeSpec\Updater\Adapter;

use Humbug\SelfUpdate\Strategy\GithubStrategy;
use Humbug\SelfUpdate\Updater;
use Sugarcrm\UpgradeSpec\Updater\UpdaterInterface;

class HumbugAdapter implements AdapterInterface
{
    /**
     * @var Updater
     */
    private $updater;

    /**
     * HumbugAdapter constructor.
     * @param Updater $updater
     */
    public function __construct(Updater $updater)
    {
        $this->updater = $updater;
    }

    /**
     * @return bool
     */
    public function hasUpdate()
    {
        return $this->updater->hasUpdate();
    }

    /**
     * @return mixed
     */
    public function getOldVersion()
    {
        return $this->updater->getStrategy()->getOldVersion();
    }

    /**
     * @return mixed
     */
    public function getNewVersion()
    {
        return $this->updater->getStrategy()->getNewVersion();
    }

    /**
     * @param string $stability
     * @return bool
     */
    public function update($stability = UpdaterInterface::STABILITY_ANY)
    {
        $strategy = $this->updater->getStrategy();
        if ($strategy instanceof GithubStrategy) {
            $this->updater->getStrategy()->setStability($this->getGithubStability($stability));
        }

        $result = $this->updater->update();

        $this->performCleanup();

        return $result;
    }

    /**
     * @return bool
     */
    public function rollback()
    {
        return $this->updater->rollback();
    }

    /**
     * @param $stability
     * @return string
     */
    private function getGithubStability($stability)
    {
        if ($stability == UpdaterInterface::STABILITY_STABLE) {
            return GithubStrategy::STABLE;
        }

        if ($stability == UpdaterInterface::STABILITY_UNSTABLE) {
            return GithubStrategy::UNSTABLE;
        }

        return GithubStrategy::ANY;
    }

    /**
     * Removes PHAR update leftovers
     */
    private function performCleanup()
    {
        $tmpKeyFile = sprintf('%s/%s.phar.temp.pubkey',
            $this->updater->getTempDirectory(),
            $this->updater->getLocalPharFileBasename()
        );
        @unlink($tmpKeyFile);
    }
}
