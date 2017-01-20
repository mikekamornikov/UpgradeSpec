<?php

namespace Sugarcrm\UpgradeSpec\Cache\Adapter;

use Sugarcrm\UpgradeSpec\Cache\Exception\InvalidArgumentException;

trait AdapterTrait
{
    /**
     * Default TTL
     * @var int
     */
    private $ttl = 0;

    /**
     * Obtains multiple cache items by their unique keys.
     * @param iterable $keys    A list of keys that can obtained in a single operation.
     * @param mixed    $default Default value to return for keys that do not exist.
     * @return iterable A list of key => value pairs. Cache keys that do not exist or are stale will have $default as value.
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
     * @param iterable              $values A list of key => value pairs for a multiple-set operation.
     * @param null|int|DateInterval $ttl    Optional. The TTL value of this item. If no value is sent and
     *                                      the driver supports TTL then the library may set a default value
     *                                      for it or let the driver take care of that.
     * @return bool True on success and false on failure.
     */
    function setMultiple($values, $ttl = null)
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
     * @param iterable $keys A list of string-based keys to be deleted.
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
     * @param $key
     * @throws InvalidArgumentException
     */
    private function validateIterableKey($key)
    {
        if (!is_array($key) && !$key instanceof \Traversable) {
            throw new InvalidArgumentException('Argument is not traversable');
        }
    }

    /**
     * @param $key
     * @throws InvalidArgumentException
     */
    private function validateKey($key)
    {
        if (!is_string($key) || empty($key) || strlen($key) > 64) {
            throw new InvalidArgumentException(sprintf('Invalid cache key: %s', $key));
        }

        if (preg_match('/\{|\}|\(|\)|\/|\\\\|\@|\:/u', $key)) {
            throw new InvalidArgumentException('"{}()/\@:" characters are reserved by PSR-16');
        }
    }

    /**
     * @param $ttl
     * @return int
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
