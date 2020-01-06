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

use App\Stock\Domain\ProductStock;
use App\Stock\Domain\ProductStock\ProductStockAggregateRoot;
use App\Stock\Domain\ProductStock\Repository\ProductStockRepository;
use Broadway\Domain\AggregateRoot;
use Broadway\EventHandling\EventBus;
use Broadway\EventSourcing\AggregateFactory\PublicConstructorAggregateFactory;
use Broadway\EventSourcing\EventSourcingRepository;
use Broadway\EventStore\EventStore;
use Ramsey\Uuid\UuidInterface;

final class ProductStockStore extends EventSourcingRepository implements ProductStockRepository
{
    public function __construct(EventStore $eventStore, EventBus $eventBus, array $eventStreamDecorators = [])
    {
        parent::__construct(
            $eventStore,
            $eventBus,
            ProductStockAggregateRoot::class,
            new PublicConstructorAggregateFactory(),
            $eventStreamDecorators
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

    public function store(ProductStock $stock): void
    {
        $this->save($stock);
    }
}
