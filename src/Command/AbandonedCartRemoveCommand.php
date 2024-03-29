<?php

declare(strict_types=1);

namespace Lemisoft\SyliusAbandonedCartPlugin\Command;

use Exception;
use Lemisoft\SyliusAbandonedCartPlugin\Service\AbandonedCartService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'lemisoft:sylius-abandoned-cart:remove')]
final class AbandonedCartRemoveCommand extends Command
{
    private const DEFAULT_LIMIT = 100;

    public function __construct(private AbandonedCartService $abandonedCartService)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addOption(
                'limit',
                null,
                InputOption::VALUE_OPTIONAL,
                'Limit',
                self::DEFAULT_LIMIT,
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $limit = (int)$input->getOption('limit');

        $abandonedCarts = $this->abandonedCartService->getAbandonedCartsToRemove($limit);

        foreach ($abandonedCarts as $abandonedCart) {
            try {
                $this->abandonedCartService->removeAbandonedCart($abandonedCart);
            } catch (Exception) {
            }
        }

        return Command::SUCCESS;
    }
}
