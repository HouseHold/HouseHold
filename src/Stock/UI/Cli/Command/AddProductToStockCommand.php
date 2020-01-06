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
use App\Stock\Application\Command\AddProductToStock\AddProductToStockCommand as BusCommand;
use App\Stock\Domain\Product\Exception\ProductNotFoundByNameException;
use App\Stock\Domain\Product\Repository\GetProductByName;
use App\Stock\Domain\ProductLocation\Exception\ProductLocationNotFoundByNameException;
use App\Stock\Domain\ProductLocation\Repository\GetProductLocationByName;
use League\Tactician\CommandBus;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class AddProductToStockCommand extends Command
{
    /**
     * @var CommandBus
     */
    private CommandBus $commandBus;
    /**
     * @var GetProductByName
     */
    private GetProductByName $productRepo;
    /**
     * @var GetProductLocationByName
     */
    private GetProductLocationByName $locationRepo;

    public function __construct(
        CommandBus $commandBus,
        GetProductByName $productRepo,
        GetProductLocationByName $locationRepo
    ) {
        parent::__construct();
        $this->commandBus = $commandBus;
        $this->productRepo = $productRepo;
        $this->locationRepo = $locationRepo;
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
     */
    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $amount = (int) $input->getArgument('amount');
        if ($amount < 0) {
            throw new InputValidationException('Amount must be number and > 0.');
        }

        $command = new BusCommand(
            $this->productRepo->getProductByName($input->getArgument('product')),
            DateTime::fromString($input->getArgument('best-before')),
            $amount,
            $this->locationRepo->getProductLocationByName($input->getArgument('location'))
        );

        $this->commandBus->handle($command);
    }
}
