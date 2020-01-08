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

use App\Stock\Domain\Product;
use App\Stock\Domain\ProductLocation;
use App\Stock\Domain\ProductStock;

interface GetProductStockByProductAndLocation
{
    /**
     * Find ProductStock with given parameters or throw exception if not found.
     *
     * @throws ProductStock\Exception\ProductStockNotFoundByNameAndLocationException
     */
    public function getProductStockByProductAndLocation(Product $product, ProductLocation $location): ProductStock;
}
