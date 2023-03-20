<?php

declare(strict_types=1);

namespace Lemisoft\SyliusAbandonedCartPlugin\Service;

use Doctrine\ORM\EntityManagerInterface;
use Lemisoft\SyliusAbandonedCartPlugin\Repository\AbandonedCartRepositoryInterface;
use Sylius\Component\Core\Model\OrderInterface;

class AbandonedCartService
{
    public function __construct(
        private AbandonedCartRepositoryInterface $orderRepository,
        private EntityManagerInterface $em,
        private int $hoursToRemoveAbandonedCart,
    ) {
    }

    /**
     * @return OrderInterface[]
     */
    public function getAbandonedCartsToRemove(int $limit): array
    {
        return $this->orderRepository->getAbandonedCartToRemove($this->hoursToRemoveAbandonedCart, $limit);
    }

    public function removeAbandonedCart(OrderInterface $abandonedCart): void
    {
        $this->em->remove($abandonedCart);
        $this->em->flush();
    }
}
