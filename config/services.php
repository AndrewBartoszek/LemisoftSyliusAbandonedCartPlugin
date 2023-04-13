<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Lemisoft\SyliusAbandonedCartPlugin\EventListener\MenuBuilderListener;
use Lemisoft\SyliusAbandonedCartPlugin\Menu\AbandonedCartMenuBuilder;
use Symfony\Component\DependencyInjection\ContainerBuilder;

return static function (ContainerConfigurator $containerConfigurator, ContainerBuilder $a) {
    $services = $containerConfigurator->services();

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
};
