<?php

namespace Sugarcrm\UpgradeSpec\DI\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

class DataProviderPass implements CompilerPassInterface
{
    /**
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->has('data.provider_chain')) {
            return;
        }

        $providerChain = $container->findDefinition('data.provider_chain');

        $taggedProviders = $container->findTaggedServiceIds('data.provider');
        $providers = array_map(function ($id) {
            return new Reference($id);
        }, array_keys($taggedProviders));

        $providerChain->addMethodCall('addProviders', [$providers]);
    }
}
