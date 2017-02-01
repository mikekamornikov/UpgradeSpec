<?php

namespace Sugarcrm\UpgradeSpec\Cache\Adapter;

use Psr\SimpleCache\CacheInterface;
use Sugarcrm\UpgradeSpec\Cache\Exception\InvalidArgumentException;

/**
 * PSR-16 compatible file based cache adapter.
 */
class File implements CacheInterface
{
    use AdapterTrait;

    /**
     * @var string
     */
    private $cachePath;

    /**
     * File constructor.
     *
     * @param $path
     * @param $ttl
     */
    public function __construct($path, $ttl = 3600)
    {
        $this->createDirectory($path);

        $this->cachePath = realpath($path);
        $this->ttl = $ttl;

        $this->cleanExpired();
    }

    /**
     * @param string $key
     * @param null   $default
     *
     * @return bool|mixed|null
     */
    public function get($key, $default = null)
    {
        $this->validateKey($key);

        $path = $this->getPath($key);

        $expire = @filemtime($path);
        if ($expire === false) {
            return $default; // file not found
        }

        if (time() >= $expire) {
            @unlink($path); // file expired

            return $default;
        }

        $data = @file_get_contents($path);
        if ($data === false) {
            return $default; // race condition: file not found
        }

        if ($data === 'b:0;') {
            return false; // because we can't otherwise distinguish a FALSE from unserialize()
        }

        $value = @unserialize($data);
        if ($value === false) {
            return $default; // unserialize() failed
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

        $path = $this->getPath($key);
        $this->createDirectory(dirname($path));

        $expire = $this->getExpire($ttl);

        $tempPath = $this->cachePath . DIRECTORY_SEPARATOR . uniqid('', true);
        if (false === @file_put_contents($tempPath, serialize($value))) {
            return false;
        }

        if (@touch($tempPath, $expire) && @rename($tempPath, $path)) {
            return true;
        }

        @unlink($tempPath);

        return false;
    }

    /**
     * @param string $key
     *
     * @return bool
     */
    public function delete($key)
    {
        $this->validateKey($key);

        if (!$this->has($key)) {
            return false;
        }

        @unlink($this->getPath($key));

        return true;
    }

    /**
     * Remove all cache entries.
     */
    public function clear()
    {
        foreach ($this->getCacheFolderIterator() as $fileInfo) {
            if ($fileInfo->isDir()) {
                @rmdir($fileInfo->getRealPath());
            }

            @unlink($fileInfo->getRealPath());
        }

        @rmdir($this->cachePath);

        return true;
    }

    /**
     * @param string $key
     *
     * @return bool
     *
     * @throws InvalidArgumentException
     */
    public function has($key)
    {
        $this->validateKey($key);

        return $this->get($key, $this) !== $this;
    }

    /**
     * Clean up expired cache entries.
     */
    private function cleanExpired()
    {
        $now = time();
        foreach ($this->getCacheFolderIterator() as $fileInfo) {
            if (!$fileInfo->isDir() && $now > filemtime($fileInfo->getRealPath())) {
                @unlink($fileInfo->getRealPath());
            }
        }
    }

    /**
     * Creates writable directory in given path.
     *
     * @param $path
     *
     * @throws InvalidArgumentException
     */
    private function createDirectory($path)
    {
        if (!file_exists($path)) {
            @mkdir($path, 0777, true);
        }

        $path = realpath($path);
        if ($path === false) {
            throw new InvalidArgumentException(sprintf('Cache path does not exist: %s', $path));
        }

        if (!is_writable($path . DIRECTORY_SEPARATOR)) {
            throw new InvalidArgumentException(sprintf('Cache path is not writable: %s', $path));
        }
    }

    /**
     * For a given cache key, obtain the absolute file path.
     *
     * @param string $key
     *
     * @return string absolute path to cache file
     */
    private function getPath($key)
    {
        $hash = hash('sha256', $key);

        return $this->cachePath
            . DIRECTORY_SEPARATOR
            . mb_strtoupper($hash[0])
            . DIRECTORY_SEPARATOR
            . mb_strtoupper($hash[1])
            . DIRECTORY_SEPARATOR
            . mb_substr($hash, 2);
    }

    /**
     * @return \RecursiveIteratorIterator
     */
    private function getCacheFolderIterator()
    {
        return new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($this->cachePath, \RecursiveDirectoryIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::CHILD_FIRST
        );
    }
}
