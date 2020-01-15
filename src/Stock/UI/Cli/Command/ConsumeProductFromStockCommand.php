<?php

declare(strict_types=1);

/**
 *
 * Household 2020 — NOTICE OF LICENSE
 * This source file is released under commercial license by copyright holders.
 *
 * @copyright 2017-2020 (c) Niko Granö (https://granö.fi)
 * @copyright 2014-2020 (c) IronLions (https://ironlions.fi)
 *
 */

namespace App\Stock\UI\Cli\Command;

use App\Core\Domain\Shared\Exception\Cli\InputValidationException;
use App\Core\Domain\Shared\Exception\DateTimeException;
use App\Core\Domain\Shared\ValueObject\DateTime;
use App\Stock\Application\Command\ConsumeProductFromStock\ConsumeProductFromStockCommand as ConsumeCommand;
use App\Stock\Domain\Product\Exception\ProductNotFoundByNameException;
use App\Stock\Domain\Product\Repository\GetProductByName;
use App\Stock\Domain\ProductLocation\Exception\ProductLocationNotFoundByNameException;
use App\Stock\Domain\ProductLocation\Repository\GetProductLocationByName;
use App\Stock\Domain\ProductStock\Exception\ProductStockNotFoundByNameAndLocationException;
use App\Stock\Domain\ProductStock\Repository\GetProductStockByProductAndLocation;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;

final class ConsumeProductFromStockCommand extends Command
{
    private MessageBusInterface $commandBus;
    private GetProductByName $productRepo;
    private GetProductLocationByName $locationRepo;
    private GetProductStockByProductAndLocation $stockRepo;

    public function __construct(
        MessageBusInterface $commandBus,
        GetProductByName $productRepo,
        GetProductLocationByName $locationRepo,
        GetProductStockByProductAndLocation $stockRepo
    ) {
        parent::__construct();
        $this->commandBus = $commandBus;
        $this->productRepo = $productRepo;
        $this->locationRepo = $locationRepo;
        $this->stockRepo = $stockRepo;
    }

    protected function configure(): void
    {
        $this
            ->setName('hh:stock:consume')
            ->setDescription('Consume given amount of given product from stock.')
            ->addArgument('product-name', InputArgument::REQUIRED, 'Product Name')
            ->addArgument('location-name', InputArgument::REQUIRED, 'Location name.')
            ->addArgument('quantity', InputArgument::REQUIRED, 'Total quantity of products being added.')
            ->addArgument('best-before', InputArgument::OPTIONAL, 'Best Before Date for product(s).')
        ;
    }

    /**
     * @throws ProductNotFoundByNameException
     * @throws ProductLocationNotFoundByNameException
     * @throws ProductStockNotFoundByNameAndLocationException
     * @throws InputValidationException
     * @throws DateTimeException
     */
    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $product = $this->productRepo->getProductByName($input->getArgument('product-name'));
        $location = $this->locationRepo->getProductLocationByName($input->getArgument('location-name'));
        $stock = $this->stockRepo->getProductStockByProductAndLocation($product, $location);

        if ($product->expiring && null === $input->getArgument('best-before')) {
            throw new InputValidationException('Best before must be given for this product.');
        }

        $bestBefore = $product->expiring ? DateTime::fromString($input->getArgument('best-before')) : null;
        if (($quantity = (int) $input->getArgument('quantity')) < 0) {
            throw new InputValidationException('Quantity must be number and > 0.');
        }

        $this->commandBus->dispatch(new ConsumeCommand($stock, $bestBefore, $quantity));
    }
}
