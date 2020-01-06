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
use Broadway\EventSourcing\EventSourcedAggregateRoot;

class ProductStockAggregateRoot extends EventSourcedAggregateRoot
{
    private string $id;

    public Product $product;

    public ProductLocation $location;

    public int $amount;

    public static function create(string $id, Product $product, ProductLocation $location, int $amount)
    {
        $stock = new static();
        $stock->apply(
            new ProductAddedToStock($id, $product, $location, $amount)
        );
    }

    protected function applyProductAddedToStock(ProductAddedToStock $event): void
    {
        $this->id = $event->id;
        $this->product = $event->product;
        $this->location = $event->location;
        $this->amount = $event->amount;
    }

    /**
     * {@inheritdoc}
     */
    public function getAggregateRootId(): string
    {
        return $this->id;
    }
}
