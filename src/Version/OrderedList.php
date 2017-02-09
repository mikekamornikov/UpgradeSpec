<?php

namespace Sugarcrm\UpgradeSpec\Version;

class OrderedList implements \IteratorAggregate, \Countable, \Serializable
{
    /**
     * @var Version[]
     */
    private $versions = [];

    /**
     * Range constructor.
     *
     * @param array $versions
     */
    public function __construct(array $versions = [])
    {
        foreach ($versions as $version) {
            $this->addVersion($version);
        }

        // sort versions (jASC)
        usort($this->versions, function (Version $v1, Version $v2) {
            $v1 = (string) $v1->getFull();
            $v2 = (string) $v2->getFull();

            return version_compare($v1, $v2, '<') ? -1 : (version_compare($v1, $v2, '>') ? 1 : strnatcmp((string) $v1, (string) $v2));
        });
    }

    /**
     * @param array $versions
     * @param bool $checkAliases
     *
     * @return OrderedList
     */
    public function addVersions(array $versions, $checkAliases = false)
    {
        return $this->merge(new OrderedList($versions), $checkAliases);
    }

    /**
     * @param OrderedList $range
     * @param bool $checkAliases
     *
     * @return OrderedList
     */
    public function merge(OrderedList $range, $checkAliases = false)
    {
        $filtered = $range->filter(function (Version $version) use ($checkAliases) {
            return !$this->contains($version, $checkAliases);
        });

        return new self(array_merge($this->versions, iterator_to_array($filtered)));
    }

    /**
     * @param Version $version
     * @param bool $checkAliases
     *
     * @return bool
     */
    public function contains(Version $version, $checkAliases = false)
    {
        if ($checkAliases) {
            return in_array($version->getFull(), $this->map(function (Version $version) {
                return $version->getFull();
            }));
        }

        return in_array((string) $version, array_map('strval', $this->versions));
    }

    /**
     * @return Version
     */
    public function last()
    {
        if (!count($this->versions)) {
            throw new \LogicException('You can\'t get anything from empty version range');
        }

        return $this->versions[count($this->versions) - 1];
    }

    /**
     * Creates filtered range
     *
     * @param callable $callback
     *
     * @return OrderedList
     */
    public function filter(callable $callback)
    {
        return new OrderedList(array_filter($this->versions, $callback));
    }

    /**
     * Checks if range equals to the given one
     *
     * @param OrderedList $range
     * @param bool $checkAliases
     *
     * @return bool
     */
    public function isEqualTo(OrderedList $range, $checkAliases = false)
    {
        if ($checkAliases) {
            $getFull = function (Version $version) {
                return $version->getFull();
            };

            return (new OrderedList($range->map($getFull)))->isEqualTo(new OrderedList($this->map($getFull)), false);
        }

        return $this->__toString() === (string) $range;
    }

    /**
     * Maps versions to something else
     *
     * @param callable $callback
     *
     * @return array
     */
    public function map(callable $callback)
    {
        return array_map($callback, $this->versions);
    }

    /**
     * Retrieve an external iterator.
     *
     * @return \Traversable
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->versions);
    }

    /**
     * Count elements of an object.
     *
     * @return int The custom count as an integer.
     */
    public function count()
    {
        return count($this->versions);
    }

    /**
     * String representation of object.
     *
     * @return string the string representation of the object or null
     */
    public function serialize()
    {
        return serialize($this->versions);
    }

    /**
     * Constructs the object.
     *
     * @param string $serialized
     *
     * @return void
     */
    public function unserialize($serialized)
    {
        $this->versions = unserialize($serialized);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return '[' . implode(', ', $this->versions) . ']';
    }

    /**
     * @param $version
     * @param bool $checkAliases
     */
    private function addVersion($version, $checkAliases = false)
    {
        if (!($version instanceof Version)) {
            $version = new Version($version);
        }

        if (!$this->contains($version, $checkAliases)) {
            $this->versions[] = $version;
        }
    }
}
