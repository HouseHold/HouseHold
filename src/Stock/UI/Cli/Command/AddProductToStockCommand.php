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
use App\Stock\Application\Command\AddProductToStock\AddProductToStockCommand as AddCommand;
use App\Stock\Application\Command\InitializeProductStock\InitializeProductStockCommand as InitCommand;
use App\Stock\Domain\Product;
use App\Stock\Domain\Product\Exception\ProductNotFoundByNameException;
use App\Stock\Domain\Product\Repository\GetProductByName;
use App\Stock\Domain\ProductLocation;
use App\Stock\Domain\ProductLocation\Exception\ProductLocationNotFoundByNameException;
use App\Stock\Domain\ProductLocation\Repository\GetProductLocationByName;
use App\Stock\Domain\ProductStock;
use App\Stock\Domain\ProductStock\Exception\ProductStockNotFoundByNameAndLocationException;
use App\Stock\Domain\ProductStock\Repository\GetProductStockByProductAndLocation;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;

final class AddProductToStockCommand extends Command
{
    private MessageBusInterface $commandBus;
    private GetProductByName $productRepo;
    private GetProductLocationByName $locationRepo;
    private ProductLocation $productLocation;
    private ProductStock $stock;
    private Product $product;
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
            ->setName('hh:stock:add')
            ->setDescription('Add given amount of given product into stock.')
            ->addArgument('product', InputArgument::REQUIRED, 'Product Name')
            ->addArgument('location', InputArgument::REQUIRED, 'Location name.')
            ->addArgument('quantity', InputArgument::REQUIRED, 'Total quantity of products being added.')
            ->addArgument('price', InputArgument::REQUIRED, 'Price per product.')
            ->addArgument('best-before', InputArgument::OPTIONAL, 'Best Before Date for product(s).')
        ;
    }

    /**
     * @throws ProductNotFoundByNameException
     * @throws ProductLocationNotFoundByNameException
     * @throws InputValidationException
     * @throws DateTimeException
     * @throws ProductStockNotFoundByNameAndLocationException
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->product = $this->productRepo->getProductByName($input->getArgument('product'));
        $this->productLocation = $this->locationRepo->getProductLocationByName($input->getArgument('location'));

        // Try find stock. If not found, create and retry. If fails, let it fail.
        try {
            $this->stock = $this->stockRepo->getProductStockByProductAndLocation($this->product, $this->productLocation);
        } catch (ProductStockNotFoundByNameAndLocationException $e) {
            $output->writeln('Stock not found. Creating one...', OutputInterface::VERBOSITY_VERBOSE);
            $this->commandBus->dispatch($this->getInitCommand());
            $this->stock = $this->stockRepo->getProductStockByProductAndLocation($this->product, $this->productLocation);
        }

        $this->commandBus->dispatch($this->getAddCommand($input));

        return 0;
    }

    /**
     * @param int $amount
     *
     * @throws DateTimeException
     * @throws InputValidationException
     */
    private function getAddCommand(InputInterface $input): AddCommand
    {
        $quantity = (int) $input->getArgument('quantity');
        if ($quantity < 0) {
            throw new InputValidationException('Quantity must be number and > 0.');
        }

        $price = (float) $input->getArgument('price');
        if ($price <= 0) {
            throw new InputValidationException('Price must be float and cannot be negative.');
        }

        return new AddCommand(
            $this->stock,
            DateTime::fromString($input->getArgument('best-before')),
            $quantity,
            $price
        );
    }

    private function getInitCommand()
    {
        return new InitCommand(
            $this->product,
            $this->productLocation
        );
    }
}
