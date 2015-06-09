<?php

namespace FDevs\MigrationBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\Kernel;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class FDevsMigrationExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));

        $config['dirs'] = array_merge($config['dirs'], $this->getDirectory($container));
        $container->setParameter($this->getAlias().'.migrations_dirs', $config['dirs']);
        $config['configuration_file'] = $config['configuration_file'] ?: $container->getParameter('kernel.root_dir').'/../var/version';
        $container->setParameter($this->getAlias().'.configuration_file', $config['configuration_file']);
        $container->setParameter($this->getAlias().'.doctrine.table', $config['doctrine_table']);

        if (!$config['service_configuration'] && $config['configuration'] !== 'custom') {
            if ($config['db_driver'] !== 'custom') {
                $container->setParameter($this->getAlias().'.doctrine.manager_name', $config['doctrine_manager']);
                $loader->load(sprintf('%s.xml', $config['db_driver']));
            }
            $config['service_configuration'] = $this->getAlias().'.configuration.'.$config['configuration'];
            $loader->load(sprintf('configuration/%s.xml', $config['configuration']));
        }

        $container->setAlias($this->getAlias().'.configuration', $config['service_configuration']);
        $container->setAlias($this->getAlias().'.provider', $config['service_provider']);

        $loader->load('services.xml');
    }

    private function getDirectory(ContainerBuilder $container)
    {
        $dirs = [];
        $basedir = realpath($container->getParameter('kernel.root_dir').'/Resources/Migrations');
        if (is_dir($basedir)) {
            $dirs[] = $basedir;
        }
        foreach ($container->getParameter('kernel.bundles') as $bundle => $class) {
            $reflection = new \ReflectionClass($class);
            if (is_dir($dir = dirname($reflection->getFilename()).'/Migrations')) {
                $dirs[] = $dir;
            }
        }

        return $dirs;
    }
}
