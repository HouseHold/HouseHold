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

namespace App\Stock\Domain\ProductStock;

use App\Core\Infrastructure\Singletons\EvenDispatcherSingleton;
use App\Stock\Domain\ProductStock\Event\ProductAddedToStock;
use App\Stock\Domain\ProductStock\Event\ProductConsumedStock;
use App\Stock\Domain\ProductStock\Event\ProductInitializedStock;
use App\Stock\Domain\ProductStock\Event\ProductStockEventApplied;
use Broadway\EventSourcing\EventSourcedAggregateRoot;
use Ramsey\Uuid\UuidInterface as Id;

final class ProductStockAggregateRoot extends EventSourcedAggregateRoot
{
    private Id $id;
    private Id $product;
    private Id $location;
    private int $quantity;

    public static function create(Id $id, Id $product, Id $location, int $amount = 0): self
    {
        $stock = new static();
        $stock->apply(new ProductInitializedStock($id, $product, $location, $amount));

        return $stock;
    }

    public function apply($event): void
    {
        parent::apply($event);
        EvenDispatcherSingleton::get()->dispatch(new ProductStockEventApplied($this));
    }

    /** @noinspection PhpUnused */
    protected function applyProductAddedToStock(ProductAddedToStock $event): void
    {
        $this->quantity += $event->quantity;
    }

    /** @noinspection PhpUnused */
    protected function applyProductInitializedStock(ProductInitializedStock $event): void
    {
        $this->id = $event->id;
        $this->product = $event->product;
        $this->location = $event->location;
        $this->quantity = $event->quantity;
    }

    /** @noinspection PhpUnused */
    protected function applyProductConsumedStock(ProductConsumedStock $event): void
    {
        $this->quantity -= $event->quantity;
    }

    /**
     * {@inheritdoc}
     */
    public function getAggregateRootId(): string
    {
        return $this->id->toString();
    }

    public function getProduct(): Id
    {
        return $this->product;
    }

    public function getLocation(): Id
    {
        return $this->location;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }
}
