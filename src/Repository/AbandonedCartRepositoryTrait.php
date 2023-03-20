<?php

declare(strict_types=1);

namespace Lemisoft\SyliusAbandonedCartPlugin\Repository;

use DateTime;
use Doctrine\ORM\QueryBuilder;
use Sylius\Component\Core\Model\OrderInterface;

trait AbandonedCartRepositoryTrait
{
    public function getAbandonedCart(int $id, int $hoursToAbandonedCart): ?OrderInterface
    {
        $qb =  $this->createQueryBuilder('o');
        $qb = $this->getAbandonedCartCriteria($qb, $hoursToAbandonedCart);

        return $qb
            ->andWhere('o.id = :orderId')
            ->setParameter('orderId', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function createAbandonedCartListQueryBuilder(int $hoursToAbandonedCart): QueryBuilder
    {
        $qb =  $this->createQueryBuilder('o');
        $qb = $this->getAbandonedCartCriteria($qb, $hoursToAbandonedCart);

        return $qb
            ->addSelect('customer')
            ->leftJoin('o.customer', 'customer');
    }

    /**
     * @return OrderInterface[]
     */
    public function getAbandonedCartToRemove(int $hoursToRemoveAbandonedCart, int $limit): array
    {
        $qb =  $this->createQueryBuilder('o');
        $qb = $this->getAbandonedCartCriteria($qb, $hoursToRemoveAbandonedCart);

        return $qb
            ->addSelect('customer')
            ->leftJoin('o.customer', 'customer')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    protected function getAbandonedCartCriteria(QueryBuilder $qb, int $hoursToAbandonedCart): QueryBuilder
    {
        $now = new DateTime();
        $borderTime = $now->modify('-' . $hoursToAbandonedCart . ' hour');
        $qb->andWhere('o.state = :state')
            ->andWhere('o.createdAt < :borderTime')
            ->setParameter('state', OrderInterface::STATE_CART)
            ->setParameter('borderTime', $borderTime);

        return $qb;
    }
}
