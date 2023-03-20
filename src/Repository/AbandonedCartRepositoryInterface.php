<?php

declare(strict_types=1);

namespace Lemisoft\SyliusAbandonedCartPlugin\Repository;

use Doctrine\ORM\QueryBuilder;
use Sylius\Component\Core\Model\OrderInterface;

interface AbandonedCartRepositoryInterface
{
    public function getAbandonedCart(int $id, int $hoursToAbandonedCart): ?OrderInterface;

    public function createAbandonedCartListQueryBuilder(int $hoursToAbandonedCart): QueryBuilder;

    /**
     * @return OrderInterface[]
     */
    public function getAbandonedCartToRemove(int $hoursToRemoveAbandonedCart, int $limit): array;
}
