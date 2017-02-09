<?php

namespace Sugarcrm\UpgradeSpec\Version\Graph;

use Sugarcrm\UpgradeSpec\Version\OrderedList;
use Sugarcrm\UpgradeSpec\Version\Version;

final class AdjacencyList implements \ArrayAccess, \IteratorAggregate
{
    /**
     * @var array
     */
    private $container = [];

    /**
     * AdjacencyList constructor.
     *
     * @param array $edges
     */
    public function __construct(array $edges = [])
    {
        $versions = new OrderedList(call_user_func_array('array_merge', $edges));

        // init container
        foreach ($versions as $version) {
            $this->container[(string) $version] = new OrderedList();
        }

        // add edges
        foreach ($edges as $edge) {
            $this->container[(string) $edge[0]] = ($this->container[(string) $edge[0]])->addVersions([$edge[1]]);
        }

        // add parent edges
        foreach ($versions as $version) {
            $minorVersions = $versions->filter(function (Version $minorVersion) use ($version) {
                return $minorVersion->isChildOf($version);
            });

            // link all minor versions to existing parent versions
            foreach ($minorVersions as $minorVersion) {
                $this->container[(string) $minorVersion] = ($this->container[(string) $minorVersion])->addVersions([$version]);
            }
        }
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
        $this->container[(string) $offset] = $value;
    }

    /**
     * @param mixed $offset
     *
     * @return bool
     */
    public function offsetExists($offset)
    {
        return isset($this->container[(string) $offset]);
    }

    /**
     * @param mixed $offset
     */
    public function offsetUnset($offset)
    {
        unset($this->container[(string) $offset]);
    }

    /**
     * @param mixed $offset
     *
     * @return mixed|null
     */
    public function offsetGet($offset)
    {
        return isset($this->container[(string) $offset]) ? $this->container[(string) $offset] : null;
    }

    /**
     * Retrieve an external iterator.
     *
     * @return \Traversable
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->container);
    }
}
