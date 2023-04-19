<?php

declare(strict_types=1);

namespace Lemisoft\SyliusAbandonedCartPlugin\EventListener;

use Lemisoft\SyliusAbandonedCartPlugin\Menu\Model\AdminMenuSectionType;
use Lemisoft\SyliusAbandonedCartPlugin\Presentation\AbandonedCartPluginRouting;
use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;

class MenuBuilderListener
{
    public function addAdminMenuItems(MenuBuilderEvent $event): void
    {
        $menu = $event->getMenu();
        $catalog = $menu->getChild(AdminMenuSectionType::CATALOG->value);

        if (null !== $catalog) {
            $catalog->addChild('banner', ['route' => AbandonedCartPluginRouting::ABANDONED_CARTS_INDEX->value])
                ->setLabel('abandoned_cart.menu_item')
                ->setLabelAttribute('icon', 'cart');
        }
    }
}
