<?php

declare(strict_types=1);

namespace Lemisoft\Tests\SyliusAbandonedCartPlugin\Unit;

use Lemisoft\SyliusAbandonedCartPlugin\DependencyInjection\LemisoftSyliusAbandonedCartExtension;
use Lemisoft\SyliusAbandonedCartPlugin\LemisoftSyliusAbandonedCartPlugin;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class LemisoftSyliusAbandonedCartPluginTest extends TestCase
{
    private const PARENT_DIRECTORY_LEVEL = 2;

    #[Test]
    public function itCreatesContainerExtensionClass(): void
    {
        $bundle = new LemisoftSyliusAbandonedCartPlugin();

        self::assertInstanceOf(LemisoftSyliusAbandonedCartExtension::class, $bundle->getContainerExtension());
    }

    #[Test]
    public function itReturnsValidExtensionPath(): void
    {
        $bundle = new LemisoftSyliusAbandonedCartPlugin();

        self::assertEquals(\dirname(__DIR__, self::PARENT_DIRECTORY_LEVEL), $bundle->getPath());
    }
}
