<?php

namespace AppBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class JsonRpcExposablePass implements CompilerPassInterface
{
    /**
     * {@inheritDoc}
     */
    public function process(ContainerBuilder $container)
    {
        $definition = $container->getDefinition('jsonrpc.jsonrpccontroller');
        $services   = $container->findTaggedServiceIds('jsonrpc.exposable');
        foreach ($services as $service => $attributes) {
            $definition->addMethodCall('addService', array($service));
        }
    }
}