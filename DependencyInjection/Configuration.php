<?php

namespace FDevs\MigrationBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('f_devs_migration');
        $supportedDrivers = ['mongodb', 'custom'];
        $configDrivers = ['mongodb', 'files', 'custom'];

        $rootNode
            ->children()
                ->enumNode('configuration')->values($configDrivers)->defaultValue('files')->end()
                ->scalarNode('service_configuration')->defaultNull()->end()
                ->scalarNode('service_provider')->cannotBeEmpty()->defaultValue('f_devs_migration.provider.chain')->end()
                ->arrayNode('dirs')
                    ->defaultValue([])
                    ->prototype('scalar')->end()
                ->end()
                ->scalarNode('configuration_file')
                    ->example('%kernel.root_dir%/../var/version')
                    ->defaultNull()
                ->end()
                ->scalarNode('doctrine_manager')->defaultNull()->end()
                ->scalarNode('doctrine_table')->defaultValue('_fdevs_migrations')->end()
                ->scalarNode('db_driver')
                    ->cannotBeEmpty()
                    ->defaultValue('mongodb')
                    ->validate()
                    ->ifNotInArray($supportedDrivers)
                    ->thenInvalid('The driver %s is not supported. Please choose one of '.json_encode($supportedDrivers))
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
