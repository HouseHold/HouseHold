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

namespace App\Stock\Domain\ProductStock\Event;

use App\Stock\Domain\ProductStock\ProductStockAggregateRoot;
use Symfony\Contracts\EventDispatcher\Event;

final class ProductStockEventApplied extends Event
{
    public ProductStockAggregateRoot $aggregateRoot;

    public function __construct(ProductStockAggregateRoot $aggregateRoot)
    {
        $this->aggregateRoot = $aggregateRoot;
    }
}
