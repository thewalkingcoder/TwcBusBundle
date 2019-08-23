<?php

namespace Twc\BusBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Twc\BusBundle\Command\Interfaces\CommandHandler;
use Twc\BusBundle\Event\Interfaces\EventHandler;
use Twc\BusBundle\Query\Interfaces\QueryHandler;

class TwcBusExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader(
            $container,
            new FileLocator(__DIR__ . '/../Resources/config')
        );
        $container->registerForAutoconfiguration(CommandHandler::class)
            ->addTag('twc_bus.command.handler');

        $container->registerForAutoconfiguration(EventHandler::class)
            ->addTag('twc_bus.event.handler');

        $container->registerForAutoconfiguration(QueryHandler::class)
            ->addTag('twc_bus.query.handler');

        $loader->load('services.yaml');
    }
}
