<?php

namespace Bruno\SculpinBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class BrunoSculpinExtension extends Extension
{
    public function load(array $config, ContainerBuilder $container)
    {
        $config = $this->mergeConfiguration($config);

        $loader = new YamlFileLoader($container, new FileLocator());
        $loader->load(__DIR__.'/../Resources/config/services.yml');

        // this is the goal: dynamically set this "main_parser" service alias
        $container->setAlias('main_parser', $config['parser_id']);
    }

    /**
     * Takes the array of config arrays, adds some default values,
     * and then merges them into one flat config array so that later values
     * override earlier values.
     *
     * This is normally done via the Configuration class
     *
     * @param array $configs
     * @return mixed
     */
    private function mergeConfiguration(array $configs)
    {
        $treeBuilder = new TreeBuilder();
        $treeBuilder->root('bruno_sculpin')
            ->children()
                ->scalarNode('parser_id')->defaultValue('bruno_parser_service')
            ->end()
        ;

        $processor = new Processor();
        return $processor->process($treeBuilder->buildTree(), $configs);
    }
}
