<?php

declare(strict_types=1);

namespace Lemisoft\Tests\SyliusAbandonedCartPlugin\Unit\DependencyInjection;

use Doctrine\Bundle\MigrationsBundle\DependencyInjection\DoctrineMigrationsExtension;
use Lemisoft\SyliusAbandonedCartPlugin\DependencyInjection\Configuration;
use Lemisoft\SyliusAbandonedCartPlugin\DependencyInjection\LemisoftSyliusAbandonedCartExtension;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use SyliusLabs\DoctrineMigrationsExtraBundle\DependencyInjection\SyliusLabsDoctrineMigrationsExtraExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class LemisoftSyliusAbandonedCartExtensionTest extends TestCase
{
    private ContainerBuilder $container;
    private LemisoftSyliusAbandonedCartExtension $extension;

    #[Test]
    public function itAutoconfiguresPrependingDoctrineMigrationWithProperMigrationsPaths(): void
    {
        $this->container->registerExtension(new DoctrineMigrationsExtension());
        $this->container->registerExtension(new SyliusLabsDoctrineMigrationsExtraExtension());

        $this->extension->load([], $this->container);
        $this->extension->prepend($this->container);

        $doctrineConf = $this->container->getExtensionConfig('doctrine_migrations');
        $syliusCond = $this->container->getExtensionConfig('sylius_labs_doctrine_migrations_extra');

        self::assertArrayHasKey('LemisoftSyliusAbandonedCartPlugin', $syliusCond[0]['migrations']);
        self::assertArrayHasKey('LemisoftSyliusAbandonedCartPlugin', $doctrineConf[0]['migrations_paths']);
        self::assertSame(['Sylius\Bundle\CoreBundle\Migrations'], $syliusCond[0]['migrations']['LemisoftSyliusAbandonedCartPlugin']);
        self::assertSame('@LemisoftSyliusAbandonedCartPlugin/migrations', $doctrineConf[0]['migrations_paths']['LemisoftSyliusAbandonedCartPlugin']);
    }

    #[Test]
    public function itDoesntAutoconfiguresPrependingDoctrineMigrationWhenIsDisabled(): void
    {
        $this->extension->load([], $this->container);
        $this->extension->prepend($this->container);

        $doctrineConf = $this->container->getExtensionConfig('doctrine_migrations');
        $syliusCond = $this->container->getExtensionConfig('sylius_labs_doctrine_migrations_extra');

        self::assertEmpty($doctrineConf);
        self::assertEmpty($syliusCond);
    }

    #[Test]
    public function itReturnsCorrectConfiguration(): void
    {
        self::assertInstanceOf(Configuration::class, $this->extension->getConfiguration([], $this->container));
    }

    protected function setUp(): void
    {
        $this->extension = new LemisoftSyliusAbandonedCartExtension();
        $this->container = new ContainerBuilder();
    }
}
