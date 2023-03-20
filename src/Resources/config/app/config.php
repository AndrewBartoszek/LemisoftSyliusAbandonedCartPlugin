<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

return static function (ContainerConfigurator $containerConfigurator) {
    $containerConfigurator->parameters()
        ->set('hours_to_abandoned_cart', '%env(int:HOURS_TO_ABANDONED_CART)%')
        ->set('hours_to_remove_abandoned_cart', '%env(int:HOURS_TO_REMOVE_ABANDONED_CART)%');

    $containerConfigurator->import(
        '@LemisoftSyliusAbandonedCartPlugin/src/Resources/config/sylius/sylius_grid.yaml',
    );
    $containerConfigurator->import(
        '@LemisoftSyliusAbandonedCartPlugin/src/Resources/config/sylius/events.yaml',
    );
};
