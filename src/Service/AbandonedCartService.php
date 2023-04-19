<?php

declare(strict_types=1);

namespace Lemisoft\SyliusAbandonedCartPlugin\Service;

use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Lemisoft\SyliusAbandonedCartPlugin\Repository\AbandonedCartRepositoryInterface;
use Psr\Log\LoggerInterface;
use Sylius\Component\Core\Model\OrderInterface;

final class AbandonedCartService
{
    public function __construct(
        private AbandonedCartRepositoryInterface $orderRepository,
        private EntityManagerInterface $em,
        private LoggerInterface $abandonedCartLogger,
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

    public function loggError(OrderInterface $abandonedCart, Exception $e): void
    {
        /** @var int $cartId */
        $cartId = $abandonedCart->getId();
        $this->abandonedCartLogger->error(
            sprintf(
                'Błąd usuwania koszyka o id: %s. Treść błędu: %s',
                $cartId,
                $e->getMessage(),
            ),
        );
    }
}
