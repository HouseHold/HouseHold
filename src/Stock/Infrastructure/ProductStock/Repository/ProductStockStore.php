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

namespace App\Stock\Infrastructure\ProductStock\Repository;

use App\Core\Infrastructure\Share\Event\Metadata\MetadataCollection;
use App\Core\Infrastructure\Share\Event\Repository\DbEventStore;
use App\Core\Infrastructure\Share\Event\Repository\EventSourcingRepository;
use App\Stock\Domain\ProductStock;
use App\Stock\Domain\ProductStock\ProductStockAggregateRoot;
use App\Stock\Domain\ProductStock\Repository\ProductStockStoreRepository;
use Broadway\Domain\AggregateRoot;
use Broadway\EventHandling\EventBus;
use Ramsey\Uuid\UuidInterface;

final class ProductStockStore extends EventSourcingRepository implements ProductStockStoreRepository
{
    public function __construct(DbEventStore $stockInventoryEventStore, EventBus $eventBus, MetadataCollection $collection)
    {
        parent::__construct(
            $stockInventoryEventStore,
            $eventBus,
            ProductStockAggregateRoot::class,
            $collection
        );
    }

    /**
     * {@inheritdoc}
     *
     * @return ProductStock|AggregateRoot
     */
    public function get(UuidInterface $id): ProductStock
    {
        return $this->load($id->toString());
    }

    public function store(ProductStockAggregateRoot $stock): void
    {
        $this->save($stock);
    }
}
