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

use App\Core\Domain\Shared\ValueObject\DateTime;
use App\Core\Infrastructure\Singletons\EvenDispatcherSingleton;
use App\Stock\Domain\ProductStock\Event\ProductAddedToStock;
use App\Stock\Domain\ProductStock\Event\ProductConsumedStock;
use App\Stock\Domain\ProductStock\Event\ProductInitializedStock;
use App\Stock\Domain\ProductStock\Event\ProductStockEventApplied;
use Broadway\EventSourcing\EventSourcedAggregateRoot;
use LogicException as L;
use Ramsey\Uuid\UuidInterface as Id;

final class ProductStockAggregateRoot extends EventSourcedAggregateRoot
{
    public const DATE_FORMAT = 'Y-m-d';

    private Id $id;
    private Id $product;
    private Id $location;
    private int $quantity = 0;
    /**
     * @var DateTime[]
     */
    private array $bestBeforeDates = [];

    public static function create(Id $id, Id $product, Id $location): self
    {
        $stock = new static();
        $stock->apply(new ProductInitializedStock($id, $product, $location));

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

        if (null !== $event->bestBefore) {
            $key = $event->bestBefore->toString(self::DATE_FORMAT);
            if (isset($this->bestBeforeDates[$key])) {
                $this->bestBeforeDates[$key] += $event->quantity;
            } else {
                $this->bestBeforeDates[$key] = $event->quantity;
            }
        }
    }

    /** @noinspection PhpUnused */
    protected function applyProductInitializedStock(ProductInitializedStock $event): void
    {
        $this->id = $event->id;
        $this->product = $event->product;
        $this->location = $event->location;
    }

    /** @noinspection PhpUnused */
    protected function applyProductConsumedStock(ProductConsumedStock $event): void
    {
        $this->quantity -= $event->quantity;
        if (null !== $event->bestBefore) {
            $key = $event->bestBefore->toString(self::DATE_FORMAT);
            if (isset($this->bestBeforeDates[$key])) {
                if ($event->quantity > \count($this->bestBeforeDates[$key])) {
                    throw new L('Tried to remove more than in stock with given date.');
                }
                $this->bestBeforeDates[$key] -= $event->quantity;
                if ($this->bestBeforeDates[$key] <= 0) {
                    unset($this->bestBeforeDates[$key]);
                }
            } else {
                throw new L('This is a bug. You should never be able to consume empty stock. Please report this!');
            }
        }
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

    public function getBestBefore(): array
    {
        return $this->bestBeforeDates;
    }
}
