<?php

declare(strict_types=1);

namespace Lemisoft\Tests\SyliusAbandonedCartPlugin\Application\Doctrine\ORM;

use Lemisoft\SyliusAbandonedCartPlugin\Repository\AbandonedCartRepositoryInterface;
use Lemisoft\SyliusAbandonedCartPlugin\Repository\AbandonedCartRepositoryTrait;
use  Sylius\Bundle\CoreBundle\Doctrine\ORM\OrderRepository as BaseOrderRepository;

class OrderRepository extends BaseOrderRepository implements AbandonedCartRepositoryInterface
{
    use AbandonedCartRepositoryTrait;
}
