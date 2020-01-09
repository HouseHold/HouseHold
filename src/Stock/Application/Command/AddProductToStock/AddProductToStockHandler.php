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

namespace App\Stock\Application\Command\AddProductToStock;

use App\Core\Application\Command\CommandHandlerInterface;
use App\Core\Infrastructure\Share\Event\Repository\DbEventStore;
use App\Stock\Application\Command\InitializeProductStock\InitializeProductStockCommand as Init;
use App\Stock\Domain\Product;
use App\Stock\Domain\ProductLocation;
use App\Stock\Domain\ProductStock;
use App\Stock\Domain\ProductStock\Exception\Handler\ProductStockEventStreamIsNotCreatedException;
use App\Stock\Domain\ProductStock\Exception\ProductStockNotFoundByNameAndLocationException;
use App\Stock\Domain\ProductStock\Repository\GetProductStockByProductAndLocation;
use Broadway\Domain\DomainEventStream;
use Broadway\EventStore\EventStreamNotFoundException;

final class AddProductToStockHandler implements CommandHandlerInterface
{
    /**
     * @var DbEventStore
     */
    private DbEventStore $stockInventoryEventStore;
    /**
     * @var GetProductStockByProductAndLocation
     */
    private GetProductStockByProductAndLocation $repo;

    public function __construct(
        DbEventStore $stockInventoryEventStore,
        GetProductStockByProductAndLocation $repo
    ) {
        $this->stockInventoryEventStore = $stockInventoryEventStore;
        $this->repo = $repo;
    }

    /**
     * @throws ProductStockNotFoundByNameAndLocationException
     * @throws ProductStockEventStreamIsNotCreatedException
     */
    public function __invoke(AddProductToStockCommand $command): void
    {
        $stock = $this->getStock($command->getProduct(), $command->getLocation());
        $eventStream = $this->getEventStream($stock);
        var_dump($stock->quantity);
        die;
    }

    /**
     * @throws ProductStockEventStreamIsNotCreatedException
     */
    private function getEventStream(ProductStock $stock): DomainEventStream
    {
        try {
            return $this->stockInventoryEventStore->load($stock->getId());
        } catch (EventStreamNotFoundException $e) {
            throw new ProductStockEventStreamIsNotCreatedException('Please run '.Init::class.' first!');
        }
    }

    /**
     * @throws ProductStockNotFoundByNameAndLocationException
     */
    private function getStock(Product $product, ProductLocation $productLocation): ProductStock
    {
        return $this->repo->getProductStockByProductAndLocation($product, $productLocation);
    }
}
