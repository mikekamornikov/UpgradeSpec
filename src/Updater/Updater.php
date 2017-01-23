<?php

namespace Sugarcrm\UpgradeSpec\Updater;

use Sugarcrm\UpgradeSpec\Updater\Adapter\AdapterInterface;
use Sugarcrm\UpgradeSpec\Updater\Exception\UpdaterException;

class Updater
{
    const STABILITY_STABLE = 'stable';
    const STABILITY_UNSTABLE = 'unstable';
    const STABILITY_ANY = 'any';

    /**
     * @var AdapterInterface
     */
    private $adapter;

    /**
     * Updater constructor.
     *
     * @param AdapterInterface $adapter
     */
    public function __construct(AdapterInterface $adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * @return mixed
     *
     * @throws UpdaterException
     */
    public function hasUpdate()
    {
        try {
            return $this->adapter->hasUpdate();
        } catch (\Exception $e) {
            throw new UpdaterException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * @return mixed
     */
    public function getOldVersion()
    {
        return $this->adapter->getOldVersion();
    }

    /**
     * @return mixed
     */
    public function getNewVersion()
    {
        return $this->adapter->getNewVersion();
    }

    /**
     * @param string $stability
     *
     * @return bool
     *
     * @throws UpdaterException
     */
    public function update($stability = self::STABILITY_ANY)
    {
        try {
            $this->validateStability($stability);

            return $this->adapter->update($stability);
        } catch (\Exception $e) {
            throw new UpdaterException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * @return mixed
     *
     * @throws UpdaterException
     */
    public function rollback()
    {
        try {
            return $this->adapter->rollback();
        } catch (\Exception $e) {
            throw new UpdaterException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * @param $stability
     */
    private function validateStability($stability)
    {
        if (!in_array($stability, [self::STABILITY_STABLE, self::STABILITY_UNSTABLE, self::STABILITY_ANY])) {
            throw new \InvalidArgumentException('Invalid stability');
        }
    }
}
