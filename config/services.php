<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Lemisoft\SyliusAbandonedCartPlugin\Command\AbandonedCartRemoveCommand;
use Lemisoft\SyliusAbandonedCartPlugin\EventListener\MenuBuilderListener;
use Lemisoft\SyliusAbandonedCartPlugin\Menu\AbandonedCartMenuBuilder;
use Lemisoft\SyliusAbandonedCartPlugin\Service\AbandonedCartService;
use Symfony\Component\DependencyInjection\ContainerBuilder;

return static function (ContainerConfigurator $containerConfigurator, ContainerBuilder $a) {
    $services = $containerConfigurator->services();
    $services
        ->set(
            'lemisoft.sylius_abandoned_cart_plugin.service.abandoned_cart.service',
            AbandonedCartService::class,
        )
        ->args([
            service('sylius.repository.order'),
            service('doctrine.orm.default_entity_manager'),
            param('hours_to_remove_abandoned_cart'),
        ]);

    $services
        ->set(
            'lemisoft.sylius_abandoned_cart_plugin.menu.abandoned_cart_menu_builder',
            AbandonedCartMenuBuilder::class,
        )
        ->args([
            service('knp_menu.factory'),
            service('event_dispatcher'),
            service('sm.factory'),
        ])
        ->tag('knp_menu.menu_builder', ['method' => 'createMenu', 'alias' => 'sylius.admin.abandoned_cart.show']);

    $services
        ->set(
            'lemisoft.sylius_abandoned_cart_plugin.event_listener.menu_builder_listener',
            MenuBuilderListener::class,
        )
        ->tag('kernel.event_listener', ['event' => 'sylius.menu.admin.main', 'method' => 'addAdminMenuItems']);

    $services
        ->set(
            'lemisoft.sylius_abandoned_cart_plugin.command.abandoned_cart_remove_command',
            AbandonedCartRemoveCommand::class,
        )
        ->args([
            service('lemisoft.sylius_abandoned_cart_plugin.service.abandoned_cart.service'),
        ])
        ->tag('console.command');
};
