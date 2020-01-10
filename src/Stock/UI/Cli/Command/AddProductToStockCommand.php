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
use League\Tactician\CommandBus;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class AddProductToStockCommand extends Command
{
    private CommandBus $commandBus;
    private GetProductByName $productRepo;
    private GetProductLocationByName $locationRepo;
    private ProductLocation $productLocation;
    private ProductStock $stock;
    private Product $product;
    private GetProductStockByProductAndLocation $stockRepo;

    public function __construct(
        CommandBus $commandBus,
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
            ->addArgument('best-before', InputArgument::REQUIRED, 'Best Before Date for product(s).')
            ->addArgument('amount', InputArgument::REQUIRED, 'Total amount of products being added.')
            ->addArgument('price', InputArgument::REQUIRED, 'Price per product.')
            ->addArgument('location', InputArgument::REQUIRED, 'Location name.')
        ;
    }

    /**
     * @throws ProductNotFoundByNameException
     * @throws ProductLocationNotFoundByNameException
     * @throws InputValidationException
     * @throws DateTimeException
     * @throws ProductStockNotFoundByNameAndLocationException
     */
    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $this->product = $this->productRepo->getProductByName($input->getArgument('product'));
        $this->productLocation = $this->locationRepo->getProductLocationByName($input->getArgument('location'));

        // Try find stock. If not found, create and retry. If fails, let it fail.
        try {
            $this->stock = $this->stockRepo->getProductStockByProductAndLocation($this->product, $this->productLocation);
        } catch (ProductStockNotFoundByNameAndLocationException $e) {
            $output->writeln('Stock not found. Creating one...', OutputInterface::VERBOSITY_VERBOSE);
            $this->commandBus->handle($this->getInitCommand());
            $this->stock = $this->stockRepo->getProductStockByProductAndLocation($this->product, $this->productLocation);
        }

        $this->commandBus->handle($this->getAddCommand($input));
    }

    /**
     * @param int $amount
     *
     * @throws DateTimeException
     * @throws InputValidationException
     */
    private function getAddCommand(InputInterface $input): AddCommand
    {
        $amount = (int) $input->getArgument('amount');
        if ($amount < 0) {
            throw new InputValidationException('Amount must be number and > 0.');
        }

        return new AddCommand(
            $this->stock,
            DateTime::fromString($input->getArgument('best-before')),
            $amount
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
