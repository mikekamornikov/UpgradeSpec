<?php

namespace Sugarcrm\UpgradeSpec\DI\Compiler;

use Sugarcrm\UpgradeSpec\Data\DataAwareInterface;
use Sugarcrm\UpgradeSpec\Template\RendererAwareInterface;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class SpecElementPass implements CompilerPassInterface
{
    /**
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->has('element.provider')) {
            return;
        }

        $providerDefinition = $container->findDefinition('element.provider');

        $elements = [];
        foreach (array_keys($container->findTaggedServiceIds('element.section')) as $id) {
            if (!$container->has($id)) {
                return;
            }

            $elementDefinition = $container->findDefinition($id);
            $elementClass = $elementDefinition->getClass();

            $reflectionClass = new \ReflectionClass($elementClass);
            if ($reflectionClass->implementsInterface(RendererAwareInterface::class)) {
                if (!$container->has('template.renderer')) {
                    return;
                }

                $elementDefinition->addMethodCall('setRenderer', [new Reference('template.renderer')]);
            }

            if ($reflectionClass->implementsInterface(DataAwareInterface::class)) {
                if (!$container->has('data.manager')) {
                    return;
                }

                $elementDefinition->addMethodCall('setDataManager', [new Reference('data.manager')]);
            }

            $elements[] = new Reference($id);
        }

        $providerDefinition->addMethodCall('addElements', [$elements]);
    }
}
