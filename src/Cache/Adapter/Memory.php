<?php

namespace Sugarcrm\UpgradeSpec\Cache\Adapter;

use Psr\SimpleCache\CacheInterface;
use Sugarcrm\UpgradeSpec\Cache\Exception\InvalidArgumentException;

/**
 * PSR-16 compatible memory based cache adapter.
 */
class Memory implements CacheInterface
{
    use AdapterTrait;

    /**
     * @var array
     */
    private $cache = [];

    /**
     * Memory constructor.
     *
     * @param $data
     * @param $ttl
     */
    public function __construct($data = [], $ttl = 3600)
    {
        $this->validateIterableKey($data);

        foreach ($data as $key => $value) {
            $this->cache[$key] = [time() + $ttl, $value];
        }

        $this->ttl = $ttl;
    }

    /**
     * @param string $key
     * @param null   $default
     *
     * @return mixed
     */
    public function get($key, $default = null)
    {
        $this->validateKey($key);

        if (!isset($this->cache[$key])) {
            return $default;
        }

        list($expire, $value) = $this->cache[$key];
        if (!is_null($expire) && $expire < time()) {
            $this->delete($key);

            return $default;
        }

        return $value;
    }

    /**
     * @param string $key
     * @param mixed  $value
     * @param null   $ttl
     *
     * @return bool
     *
     * @throws InvalidArgumentException
     */
    public function set($key, $value, $ttl = null)
    {
        $this->validateKey($key);

        $this->cache[$key] = [$this->getExpire($ttl), $value];

        return true;
    }

    /**
     * @param string $key
     *
     * @return bool
     */
    public function delete($key)
    {
        $this->validateKey($key);

        unset($this->cache[$key]);

        return true;
    }

    /**
     * @return bool
     */
    public function clear()
    {
        $this->cache = [];

        return true;
    }

    /**
     * @param string $key
     *
     * @return bool
     */
    public function has($key)
    {
        $this->validateKey($key);

        return isset($this->cache[$key]);
    }
}
