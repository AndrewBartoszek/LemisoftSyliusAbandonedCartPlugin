<?php

declare(strict_types=1);

namespace Lemisoft\Tests\SyliusAbandonedCartPlugin\Unit\DependencyInjection;

use Lemisoft\SyliusAbandonedCartPlugin\DependencyInjection\Configuration;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Config\Definition\Processor;

final class ConfigurationTest extends TestCase
{
    #[Test]
    public function itCreateEmptyConfiguration(): void
    {
        $processor = new Processor();

        self::assertEmpty($processor->processConfiguration(new Configuration(), []));
    }
}
