<?php

declare(strict_types=1);

namespace Lemisoft\Tests\SyliusAbandonedCartPlugin\Unit\Service;

use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Lemisoft\SyliusAbandonedCartPlugin\Repository\AbandonedCartRepositoryInterface;
use Lemisoft\SyliusAbandonedCartPlugin\Service\AbandonedCartService;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use Sylius\Component\Core\Model\Order;

class AbandonedCartServiceTest extends TestCase
{
    const HOURS_TO_BE_ABANDONED_CART = 1;

    #[Test]
    public function loggError(): void
    {
        $loggerMock = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $abandonedCartRepoMock = $this->getMockBuilder(AbandonedCartRepositoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $emMock = $this->getMockBuilder(EntityManagerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $loggerMock->expects(TestCase::once())->method('error');

        $service = new AbandonedCartService(
            $abandonedCartRepoMock,
            $emMock,
            $loggerMock,
            self::HOURS_TO_BE_ABANDONED_CART,
        );

        $cart = new Order();
        $error = new Exception('Błąd');

        $service->loggError($cart, $error);
    }
}
