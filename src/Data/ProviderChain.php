<?php

namespace Sugarcrm\UpgradeSpec\Data;

use Sugarcrm\UpgradeSpec\Data\Provider\ProviderInterface;

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
        if (!is_array($providers) && !$providers instanceof \Traversable) {
            throw new \InvalidArgumentException(sprintf('Argument is not traversable: %s', $providers));
        }

        $this->providers = is_array($providers) ? $providers : iterator_to_array($providers);

        $argumentException = new \InvalidArgumentException('ProviderChain constructor expects ProviderInterface[]');
        if (empty($this->providers)) {
            throw $argumentException;
        }

        foreach ($this->providers as $provider) {
            if (!is_a($provider, ProviderInterface::class)) {
                throw $argumentException;
            }
        }
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
}
