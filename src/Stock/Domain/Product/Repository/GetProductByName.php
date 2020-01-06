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

namespace App\Stock\Domain\Product\Repository;

use App\Stock\Domain\Product;

interface GetProductByName
{
    /**
     * Return product by name or throw exception.
     * Product name must be exact.
     *
     * @throws Product\Exception\ProductNotFoundByNameException
     */
    public function getProductByName(string $name): Product;
}
