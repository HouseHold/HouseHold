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

namespace App\Stock\Domain\ProductStock\Repository;

use App\Stock\Domain\ProductStock;
use App\Stock\Domain\ProductStock\ProductStockAggregateRoot;
use Ramsey\Uuid\UuidInterface;

interface ProductStockStoreRepository
{
    public function get(UuidInterface $id): ProductStock;

    public function store(ProductStockAggregateRoot $stock): void;
}
