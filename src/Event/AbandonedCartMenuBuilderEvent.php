<?php

declare(strict_types=1);

namespace Lemisoft\SyliusAbandonedCartPlugin\Event;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use SM\StateMachine\StateMachineInterface;
use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;
use Sylius\Component\Core\Model\OrderInterface;

final class AbandonedCartMenuBuilderEvent extends MenuBuilderEvent
{
    public function __construct(
        FactoryInterface $factory,
        ItemInterface $menu,
        private OrderInterface $order,
        private StateMachineInterface $stateMachine,
    ) {
        parent::__construct($factory, $menu);
    }

    public function getOrder(): OrderInterface
    {
        return $this->order;
    }

    public function getStateMachine(): StateMachineInterface
    {
        return $this->stateMachine;
    }
}
