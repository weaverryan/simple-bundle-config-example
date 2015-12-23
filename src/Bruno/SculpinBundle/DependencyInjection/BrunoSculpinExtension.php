<?php

namespace Bruno\SculpinBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class BrunoSculpinExtension extends Extension
{
    public function load(array $config, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator());
        $loader->load(__DIR__.'/../Resources/config/services.yml');

        // this is the goal: dynamically set this "main_parser" service alias
        $container->setAlias('main_parser', 'bruno_parser_service');
    }
}
