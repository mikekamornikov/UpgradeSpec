<?php

namespace Sugarcrm\UpgradeSpec\Cache;

use Psr\SimpleCache\CacheInterface;
use Sugarcrm\UpgradeSpec\Cache\Exception\CacheException;

class Cache
{
    /**
     * @var CacheInterface
     */
    private $cacheAdapter;

    /**
     * Cache constructor.
     *
     * @param CacheInterface $cacheAdapter
     */
    public function __construct(CacheInterface $cacheAdapter)
    {
        $this->cacheAdapter = $cacheAdapter;
    }

    /**
     * @param $key
     *
     * @return bool
     */
    public function has($key)
    {
        try {
            return $this->cacheAdapter->has($key);
        } catch (CacheException $e) {
            throw new \RuntimeException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * @param $key
     * @param null $default
     *
     * @return mixed
     */
    public function get($key, $default = null)
    {
        try {
            if (is_array($key) || $key instanceof \Traversable) {
                return $this->cacheAdapter->getMultiple($key, $default);
            }

            return $this->cacheAdapter->get($key, $default);
        } catch (CacheException $e) {
            throw new \RuntimeException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * @param $key
     * @param $value
     * @param null $ttl
     *
     * @return bool
     */
    public function set($key, $value, $ttl = null)
    {
        try {
            return $this->cacheAdapter->set($key, $value, $ttl);
        } catch (CacheException $e) {
            throw new \RuntimeException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * @param $values
     * @param null $ttl
     *
     * @return bool
     */
    public function setMultiple($values, $ttl = null)
    {
        try {
            return $this->cacheAdapter->setMultiple($values, $ttl);
        } catch (CacheException $e) {
            throw new \RuntimeException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * @param $key
     *
     * @return bool
     */
    public function delete($key)
    {
        try {
            if (is_array($key) || $key instanceof \Traversable) {
                return $this->cacheAdapter->deleteMultiple($key);
            }

            return $this->cacheAdapter->delete($key);
        } catch (CacheException $e) {
            throw new \RuntimeException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * @return bool
     */
    public function clear()
    {
        try {
            return $this->cacheAdapter->clear();
        } catch (CacheException $e) {
            throw new \RuntimeException($e->getMessage(), $e->getCode(), $e);
        }
    }
}
