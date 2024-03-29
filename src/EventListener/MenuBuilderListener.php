<?php

declare(strict_types=1);

namespace Lemisoft\SyliusAbandonedCartPlugin\EventListener;

use Lemisoft\SyliusAbandonedCartPlugin\Menu\Model\AdminMenuSectionType;
use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;

class MenuBuilderListener
{
    public function addAdminMenuItems(MenuBuilderEvent $event): void
    {
        $menu = $event->getMenu();
        $catalog = $menu->getChild(AdminMenuSectionType::CATALOG->value);

        if (null !== $catalog) {
            $catalog->addChild('banner', ['route' => 'lemisoft_sylius_abandoned_cart_index'])
                ->setLabel('abandoned_cart.menu_item')
                ->setLabelAttribute('icon', 'cart');
        }
    }
}
