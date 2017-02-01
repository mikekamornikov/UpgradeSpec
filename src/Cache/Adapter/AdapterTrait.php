<?php

namespace Sugarcrm\UpgradeSpec\Cache\Adapter;

use Sugarcrm\UpgradeSpec\Cache\Exception\InvalidArgumentException;

trait AdapterTrait
{
    /**
     * Default TTL.
     *
     * @var int
     */
    private $ttl = 0;

    /**
     * Obtains multiple cache items by their unique keys.
     *
     * @param iterable $keys    a list of keys that can obtained in a single operation
     * @param mixed    $default default value to return for keys that do not exist
     *
     * @return \Generator A list of key => value pairs. Cache keys that do not exist or are stale will have $default as value.
     */
    public function getMultiple($keys, $default = null)
    {
        $this->validateIterableKey($keys);

        foreach ($keys as $key) {
            yield $key => $this->get($key, $default);
        }
    }

    /**
     * Persists a set of key => value pairs in the cache, with an optional TTL.
     *
     * @param iterable              $values a list of key => value pairs for a multiple-set operation
     * @param null|int|DateInterval $ttl    Optional. The TTL value of this item. If no value is sent and
     *                                      the driver supports TTL then the library may set a default value
     *                                      for it or let the driver take care of that.
     *
     * @return bool true on success and false on failure
     */
    public function setMultiple($values, $ttl = null)
    {
        $this->validateIterableKey($values);

        $result = true;
        foreach ($values as $key => $value) {
            if (!$this->set($key, $value, $ttl)) {
                $result = false;
            }
        }

        return $result;
    }

    /**
     * Deletes multiple cache items in a single operation.
     *
     * @param iterable $keys a list of string-based keys to be deleted
     *
     * @return bool True if the items were successfully removed. False if there was an error.
     */
    public function deleteMultiple($keys)
    {
        $this->validateIterableKey($keys);

        $result = true;
        foreach ($keys as $key) {
            if (!$this->delete($key)) {
                $result = false;
            }
        }

        return $result;
    }

    /**
     * Fetches a value from the cache.
     *
     * @param string $key     The unique key of this item in the cache.
     * @param mixed  $default Default value to return if the key does not exist.
     *
     * @return mixed The value of the item from the cache, or $default in case of cache miss.
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *   MUST be thrown if the $key string is not a legal value.
     */
    public abstract function get($key, $default = null);

    /**
     * Persists data in the cache, uniquely referenced by a key with an optional expiration TTL time.
     *
     * @param string                $key   The key of the item to store.
     * @param mixed                 $value The value of the item to store, must be serializable.
     * @param null|int|DateInterval $ttl   Optional. The TTL value of this item. If no value is sent and
     *                                     the driver supports TTL then the library may set a default value
     *                                     for it or let the driver take care of that.
     *
     * @return bool True on success and false on failure.
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *   MUST be thrown if the $key string is not a legal value.
     */
    public abstract function set($key, $value, $ttl = null);

    /**
     * Delete an item from the cache by its unique key.
     *
     * @param string $key The unique cache key of the item to delete.
     *
     * @return bool True if the item was successfully removed. False if there was an error.
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *   MUST be thrown if the $key string is not a legal value.
     */
    public abstract function delete($key);

    /**
     * @param $key
     *
     * @throws InvalidArgumentException
     */
    private function validateIterableKey($key)
    {
        if (!is_array($key) && !$key instanceof \Traversable) {
            throw new InvalidArgumentException('Argument is not traversable');
        }
    }

    /**
     * @param string $key
     *
     * @throws InvalidArgumentException
     */
    private function validateKey($key)
    {
        if (!is_string($key) || empty($key) || mb_strlen($key) > 64) {
            throw new InvalidArgumentException(sprintf('Invalid cache key: %s', $key));
        }

        if (preg_match('/\{|\}|\(|\)|\/|\\\\|\@|\:/u', $key)) {
            throw new InvalidArgumentException('"{}()/\@:" characters are reserved by PSR-16');
        }
    }

    /**
     * @param $ttl
     *
     * @return int
     *
     * @throws InvalidArgumentException
     */
    private function getExpire($ttl)
    {
        $expire = time() + $this->ttl;
        if ($ttl instanceof \DateInterval) {
            $expire = (new \DateTime('now'))->add($ttl)->getTimeStamp();
        } elseif (is_int($ttl) || ctype_digit($ttl)) {
            $expire = time() + $ttl;
        } elseif ($ttl !== null) {
            throw new InvalidArgumentException(sprintf('Invalid TTL: %s', print_r($ttl, true)));
        }

        return $expire;
    }
}
