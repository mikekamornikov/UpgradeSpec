<?php

namespace Sugarcrm\UpgradeSpec\Version;

final class Version implements \Serializable
{
    /**
     * @var string
     */
    private $version;

    /**
     * Version constructor.
     *
     * @param $version
     */
    public function __construct($version)
    {
        if (!is_string($version) || !preg_match('/\d+(\.\d+){1,3}/', $version)) {
            throw new \InvalidArgumentException(sprintf('"%s" is not a valid SugarCRM version', $version));
        }

        $this->version = $version;
    }

    /**
     * @return bool
     */
    public function isMajor()
    {
        return count(explode('.', $this->version)) == 2;
    }

    /**
     * @return bool
     */
    public function isFull()
    {
        return count(explode('.', $this->version)) == 4;
    }

    /**
     * @return bool
     */
    public function isMinor()
    {
        return !$this->isMajor();
    }

    /**
     * @param Version $version
     *
     * @param bool $strict
     *
     * @return bool
     */
    public function isEqualTo(Version $version, $strict = false)
    {
        if ($strict) {
            return $this->version == (string) $version;
        }

        return (string) $this->getFull() == (string) $version->getFull();
    }

    /**
     * Checks if the current version is a subversion of given parent
     *
     * @param Version $parent
     *
     * @return bool
     */
    public function isChildOf(Version $parent)
    {
        $parent = (string) $parent;

        // exactly the same version is not a child
        if ((string) $this === $parent) {
            return false;
        }

        return implode('.', array_slice(explode('.', $this->version), 0, count(explode('.', $parent)))) === $parent;
    }

    /**
     * @return Version
     */
    public function getMajor()
    {
        if ($this->isMajor()) {
            return clone $this;
        }

        return new self(implode('.', array_slice(explode('.', $this->version), 0, 2)));
    }

    /**
     * @return Version
     */
    public function getFull()
    {
        $parts = explode('.', $this->version);
        if (count($parts) == 4) {
            return $this->version;
        }

        $parts = array_merge($parts, array_fill(0, 4 - count($parts), '0'));

        return new self(implode('.', $parts));
    }

    /**
     * Gets all version aliases
     * 7.6.0 -> [7.6, 7.6.0, 7.6.0.0], 7.6.1 -> [7.6.1, 7.6.1.0]
     *
     * @return OrderedList
     */
    public function getAliases()
    {
        if ($this->isMajor()) {
            return new OrderedList([$this, $this->version . '.0', $this->version . '.0.0']);
        }

        $parts = explode('.', $this->version);
        if ($parts[count($parts) - 1] === '0') {
            return $this->getParent()->getAliases();
        }

        $aliases = [$this];
        while (count($parts) < 4) {
            $parts[] = '0';
            $aliases[] = implode('.', $parts);
        }

        return new OrderedList($aliases);
    }

    /**
     *
     *
     * @return Version
     */
    public function getParent()
    {
        if ($this->isMajor()) {
            throw new \LogicException('Major version doesn\'t have parent');
        }

        $parts = explode('.', $this->version);
        array_pop($parts);

        return new self(implode('.', $parts));
    }

    /**
     * String representation of object.
     *
     * @return string the string representation of the object or null
     */
    public function serialize()
    {
        return serialize($this->version);
    }

    /**
     * Constructs the object.
     *
     * @param string $serialized
     */
    public function unserialize($serialized)
    {
        $this->version = unserialize($serialized);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->version;
    }
}
