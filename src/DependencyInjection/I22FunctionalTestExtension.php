<?php

namespace I22\FunctionalTestBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;

/**
 * @author Dennis Langen <dennis.langen@i22.de>
 */
class I22FunctionalTestExtension extends Extension
{
    const SERVICES_DIR = __DIR__.'/../../resources/config';

    /**
     * @param array $configs
     * @param ContainerBuilder $container
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $this->loadConfig($configs, $container);
    }

    /**
     * Loads configuration and adds the configuration values to the application parameters.
     *
     * @param array            $configs
     * @param ContainerBuilder $container
     *
     * @throws \InvalidArgumentException
     */
    private function loadConfig(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $processedConfiguration = $this->processConfiguration($configuration, $configs);
        foreach ($processedConfiguration as $key => $value) {
            $container->setParameter(
                $this->getAlias().'.'.$key,
                $value
            );
        }
    }

}