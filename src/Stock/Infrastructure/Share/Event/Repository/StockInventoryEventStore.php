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

namespace App\Stock\Infrastructure\Share\Event\Repository;

use App\Core\Infrastructure\Share\Event\Repository\DbEventStore;
use App\Core\Infrastructure\Share\Event\Repository\ORM\ORMEventStore;
use App\Stock\Domain\ProductStock\ProductStockEvent;

final class StockInventoryEventStore extends ORMEventStore implements DbEventStore
{
    protected string $entityClass = ProductStockEvent::class;
    protected string $table = 'stock_inventory_event';
}
