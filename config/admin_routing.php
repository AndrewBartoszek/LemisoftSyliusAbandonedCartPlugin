<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Lemisoft\SyliusAbandonedCartPlugin\Presentation\AbandonedCartPluginRouting;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return static function (RoutingConfigurator $routes): void {
    $routes
        ->add(AbandonedCartPluginRouting::ABANDONED_CARTS_INDEX->value, '/abandoned-carts')
        ->methods([Request::METHOD_GET])
        ->controller('sylius.controller.order::indexAction')
        ->defaults([
            '_sylius' => [
                'grid'       => 'lemisoft_sylius_abandoned_cart_admin',
                'section'    => 'admin',
                'permission' => true,
                'template'   => '@SyliusAdmin/Crud/index.html.twig',
            ],
        ]);

    $routes->add(AbandonedCartPluginRouting::ABANDONED_CARTS_DELETE->value, '/orders/{id}/remove')
        ->methods([Request::METHOD_DELETE])
        ->controller('sylius.controller.order::deleteAction')
        ->defaults([
            '_sylius' => [
                'repository' => [
                    'method'    => 'getAbandonedCart',
                    'arguments' => [
                        '!!int $id',
                        '!!int %hours_to_abandoned_cart%',
                    ],
                ],
                'section'    => 'admin',
                'permission' => true,
                'redirect'   => [
                    'route' => AbandonedCartPluginRouting::ABANDONED_CARTS_INDEX->value,
                ],
            ],
        ]);

    $routes
        ->add(AbandonedCartPluginRouting::ABANDONED_CARTS_SHOW->value, '/abandoned-carts/{id}')
        ->methods([Request::METHOD_GET])
        ->controller('sylius.controller.order::showAction')
        ->defaults([
            '_sylius' => [
                'repository' => [
                    'method'    => 'getAbandonedCart',
                    'arguments' => [
                        '!!int $id',
                        '!!int %hours_to_abandoned_cart%',
                    ],
                ],
                'section'    => 'admin',
                'permission' => true,
                'template'   => '@LemisoftSyliusAbandonedCartPlugin/Admin/AbandonedCart/show.html.twig',
            ],
        ]);
};
