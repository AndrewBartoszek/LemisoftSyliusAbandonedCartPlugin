<?php

declare(strict_types=1);

namespace Lemisoft\SyliusAbandonedCartPlugin\Presentation;

enum AbandonedCartPluginRouting: string
{
    case ABANDONED_CARTS_INDEX = 'lemisoft_sylius_abandoned_cart_index';
    case ABANDONED_CARTS_DELETE = 'lemisoft_sylius_abandoned_cart_delete';
    case ABANDONED_CARTS_SHOW = 'lemisoft_sylius_abandoned_cart_show';
}
