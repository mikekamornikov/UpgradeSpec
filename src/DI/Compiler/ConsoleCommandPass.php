<?php

namespace Sugarcrm\UpgradeSpec\DI\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class ConsoleCommandPass implements CompilerPassInterface
{
    /**
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->has('application')) {
            return;
        }

        $application = $container->findDefinition('application');

        $taggedCommands = $container->findTaggedServiceIds('console.command');
        $commands = array_map(function ($id) {
            return new Reference($id);
        }, array_keys($taggedCommands));

        $application->addMethodCall('addCommands', [$commands]);
    }
}
