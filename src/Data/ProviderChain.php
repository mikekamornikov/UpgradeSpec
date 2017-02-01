<?php

namespace Sugarcrm\UpgradeSpec\Data;

use Sugarcrm\UpgradeSpec\Data\Provider\ProviderInterface;

/**
 * @method mixed getVersions($flav)
 * @method mixed getReleaseNotes($flav, array $versions)
 * @method mixed getHealthCheckInfo($version)
 * @method mixed getUpgraderInfo($version)
 */
class ProviderChain
{
    /**
     * @var array
     */
    private $providers = [];

    /**
     * ProviderChain constructor.
     *
     * @param mixed $providers
     */
    public function __construct($providers)
    {
        $this->addProviders($providers);
    }

    /**
     * @param $name
     * @param $arguments
     *
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        foreach ($this->providers as $provider) {
            if (method_exists($provider, $name)) {
                return call_user_func_array([$provider, $name], $arguments);
            }
        }

        throw new \RuntimeException(sprintf('There is no provider with method: %s', $name));
    }

    /**
     * Adds providers to the chain.
     *
     * @param mixed $providers
     */
    public function addProviders($providers)
    {
        if (!is_array($providers) && !$providers instanceof \Traversable) {
            throw new \InvalidArgumentException(sprintf('Argument is not traversable: %s', $providers));
        }

        $providers = is_array($providers) ? $providers : iterator_to_array($providers);

        foreach ($providers as $provider) {
            if (!is_a($provider, ProviderInterface::class)) {
                throw new \InvalidArgumentException('ProviderChain expects ProviderInterface[]');
            }
        }

        $this->providers = array_merge($this->providers, $providers);
    }
}
