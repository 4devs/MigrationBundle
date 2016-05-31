<?php

namespace FDevs\MigrationBundle;

use FDevs\MigrationBundle\DependencyInjection\Compiler\ProviderCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class FDevsMigrationBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new ProviderCompilerPass());
    }
}
