<?php

use Sugarcrm\UpgradeSpec\DI\Compiler\ConsoleCommandPass;
use Sugarcrm\UpgradeSpec\DI\Compiler\DataProviderPass;
use Sugarcrm\UpgradeSpec\DI\Compiler\SpecElementPass;
use Sugarcrm\UpgradeSpec\DI\Extension\ApplicationExtension;
use Symfony\Component\Config\ConfigCache;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Dumper\PhpDumper;

require __DIR__ . '/autoload.php';
require __DIR__ . '/env.php';

$isDebug = getenv('DEV_MODE') && !\Phar::running();

$file = __DIR__ . '/ApplicationContainer.php';
$containerCache = new ConfigCache($file, $isDebug);

if (!$containerCache->isFresh()) {
    $extension = new ApplicationExtension();

    $container = new ContainerBuilder();
    $container->registerExtension($extension);
    $container->loadFromExtension($extension->getAlias());
    $container->addCompilerPass(new ConsoleCommandPass());
    $container->addCompilerPass(new DataProviderPass());
    $container->addCompilerPass(new SpecElementPass());
    $container->compile();

    $dumper = new PhpDumper($container);
    $containerCache->write(
        $dumper->dump([
            'class' => 'ApplicationContainer',
            'namespace' => 'Sugarcrm\UpgradeSpec',
        ]),
        $container->getResources()
    );
}
