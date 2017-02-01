<?php

namespace Sugarcrm\UpgradeSpec\DI\Extension;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Loader\LoaderResolver;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\DirectoryLoader;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

class ApplicationExtension extends Extension
{
    /**
     * @param array            $configs
     * @param ContainerBuilder $container
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $fileLocator = new FileLocator(APPLICATION_ROOT);
        $loader = new DirectoryLoader($container, $fileLocator);
        $loader->setResolver(new LoaderResolver([
            new XmlFileLoader($container, $fileLocator),
            $loader,
        ]));
        $loader->load('./resources/services/');
    }
}
