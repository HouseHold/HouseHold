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
use App\Stock\Domain\Product;
use App\Stock\Domain\ProductLocation;
use App\Stock\Domain\ProductStock\Event\ProductAddedToStock;
use App\Stock\Domain\ProductStock\Event\ProductInitializedStock;
use App\Stock\Domain\ProductStock\Event\ProductStockEventApplied;
use Broadway\EventSourcing\EventSourcedAggregateRoot;
use Ramsey\Uuid\Uuid;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

final class ProductStockAggregateRoot extends EventSourcedAggregateRoot
{
    private string $id;
    private string $product;
    private string $location;
    private int $quantity;
    private EventDispatcherInterface $eventDispatcher;

    public static function create(string $id, Product $product, ProductLocation $location, int $amount = 0): self
    {
        $stock = new static();
        $stock->apply(
            new ProductInitializedStock(Uuid::fromString($id), $product, $location, $amount)
        );

        return $stock;
    }

    public function apply($event): void
    {
        EvenDispatcherSingleton::get()->dispatch(new ProductStockEventApplied($this));
        parent::apply($event);
    }

    protected function applyProductAddedToStock(ProductAddedToStock $event): void
    {
        $this->quantity += $event->quantity;
    }

    protected function applyProductInitializedStock(ProductInitializedStock $event): void
    {
        $this->id = $event->id->toString();
        $this->product = $event->product->getId();
        $this->location = $event->location->getId();
        $this->quantity = $event->quantity;
    }

    /**
     * {@inheritdoc}
     */
    public function getAggregateRootId(): string
    {
        return $this->id;
    }

    public function getProduct(): string
    {
        return $this->product;
    }

    public function getLocation(): string
    {
        return $this->location;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }
}
