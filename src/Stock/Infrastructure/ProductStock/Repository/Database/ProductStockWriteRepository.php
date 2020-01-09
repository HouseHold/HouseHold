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

namespace App\Stock\Infrastructure\ProductStock\Repository\Database;

use App\Core\Infrastructure\Share\Query\Repository\DatabaseRepository;
use App\Stock\Domain\ProductStock;
use App\Stock\Domain\ProductStock\Repository\ProductStockRepository;

final class ProductStockWriteRepository extends DatabaseRepository implements ProductStockRepository
{
    protected string $class = ProductStock::class;

    public function store(ProductStock $stock): void
    {
        $this->register($stock);
    }
}
