<?php

namespace FDevs\MigrationBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class ProviderCompilerPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->has('f_devs_migration.provider.chain')) {
            return;
        }

        $definition = $container->findDefinition('f_devs_migration.provider.chain');

        $taggedServices = $container->findTaggedServiceIds('f_devs_migration.provider');
        foreach ($taggedServices as $id => $tags) {
            $definition->addMethodCall('addProvider', [new Reference($id)]);
        }
    }
}
