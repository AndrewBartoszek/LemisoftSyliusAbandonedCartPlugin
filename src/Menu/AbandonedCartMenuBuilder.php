<?php

declare(strict_types=1);

namespace Lemisoft\SyliusAbandonedCartPlugin\Menu;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Lemisoft\SyliusAbandonedCartPlugin\Event\AbandonedCartMenuBuilderEvent;
use SM\Factory\FactoryInterface as StateMachineFactoryInterface;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Order\OrderTransitions;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

final class AbandonedCartMenuBuilder
{
    public const EVENT_NAME = 'sylius.admin.abandoned_cart.show';

    public function __construct(
        private FactoryInterface $factory,
        private EventDispatcherInterface $eventDispatcher,
        private StateMachineFactoryInterface $stateMachineFactory,
    ) {
    }

    public function createMenu(array $options): ItemInterface
    {
        $menu = $this->factory->createItem('root');

        if (!isset($options['order'])) {
            return $menu;
        }

        /** @var OrderInterface $order */
        $order = $options['order'];
        $stateMachine = $this->stateMachineFactory->get($order, OrderTransitions::GRAPH);

        $this->eventDispatcher->dispatch(
            new AbandonedCartMenuBuilderEvent($this->factory, $menu, $order, $stateMachine),
            self::EVENT_NAME,
        );

        return $menu;
    }
}
