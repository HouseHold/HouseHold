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

namespace App\Stock\Application\Command\InitializeProductStock;

use App\Core\Application\Command\CommandHandlerInterface;
use App\Stock\Domain\ProductStock;
use App\Stock\Domain\ProductStock\ProductStockAggregateRoot;
use App\Stock\Domain\ProductStock\Repository\ProductStockRepository;
use App\Stock\Domain\ProductStock\Repository\ProductStockStoreRepository;

final class InitializeProductStockHandler implements CommandHandlerInterface
{
    /**
     * @var ProductStockStoreRepository
     */
    private ProductStockStoreRepository $storeRepository;
    /**
     * @var ProductStockRepository
     */
    private ProductStockRepository $repository;

    public function __construct(ProductStockStoreRepository $storeRepository, ProductStockRepository $repository)
    {
        $this->storeRepository = $storeRepository;
        $this->repository = $repository;
    }

    public function __invoke(InitializeProductStockCommand $command): void
    {
        $stock = new ProductStock(
            $command->product,
            $command->productLocation
        );
        $this->repository->store($stock);
        $this->repository->apply();

        $root = ProductStockAggregateRoot::create(
            $stock->getId(),
            $command->product,
            $command->productLocation
        );

        $this->storeRepository->store($root);
    }
}
