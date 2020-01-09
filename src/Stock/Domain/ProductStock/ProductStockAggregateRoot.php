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

use App\Stock\Domain\Product;
use App\Stock\Domain\ProductLocation;
use App\Stock\Domain\ProductStock\Event\ProductAddedToStock;
use App\Stock\Domain\ProductStock\Event\ProductInitializedStock;
use Broadway\EventSourcing\EventSourcedAggregateRoot;
use Ramsey\Uuid\Uuid;

class ProductStockAggregateRoot extends EventSourcedAggregateRoot
{
    private string $id;

    protected Product $product;

    protected ProductLocation $location;

    protected int $quantity;

    public static function create(string $id, Product $product, ProductLocation $location, int $amount = 0): self
    {
        $stock = new static();
        $stock->apply(
            new ProductInitializedStock(Uuid::fromString($id), $product, $location, $amount)
        );

        return $stock;
    }

    protected function applyProductAddedToStock(ProductAddedToStock $event): void
    {
        $this->quantity =+ $event->quantity;
    }

    protected function applyProductInitializedStock(ProductInitializedStock $event): void
    {
        $this->id = $event->id->toString();
        $this->product = $event->product;
        $this->location = $event->location;
        $this->quantity = $event->quantity;
    }

    /**
     * {@inheritdoc}
     */
    public function getAggregateRootId(): string
    {
        return $this->id;
    }
}
