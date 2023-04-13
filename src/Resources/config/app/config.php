<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Lemisoft\SyliusAbandonedCartPlugin\Command\AbandonedCartRemoveCommand;
use Lemisoft\SyliusAbandonedCartPlugin\Service\AbandonedCartService;

return static function (ContainerConfigurator $containerConfigurator) {
    $services = $containerConfigurator->services();

    $containerConfigurator->parameters()
        ->set('hours_to_abandoned_cart', '%env(int:HOURS_TO_ABANDONED_CART)%')
        ->set('hours_to_remove_abandoned_cart', '%env(int:HOURS_TO_REMOVE_ABANDONED_CART)%');

    $containerConfigurator->import(
        '@LemisoftSyliusAbandonedCartPlugin/src/Resources/config/sylius/sylius_grid.yaml',
    );
    $containerConfigurator->import(
        '@LemisoftSyliusAbandonedCartPlugin/src/Resources/config/sylius/events.yaml',
    );

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
            'lemisoft.sylius_abandoned_cart_plugin.command.abandoned_cart_remove_command',
            AbandonedCartRemoveCommand::class,
        )
        ->args([
            service('lemisoft.sylius_abandoned_cart_plugin.service.abandoned_cart.service'),
        ])
        ->tag('console.command');
};
