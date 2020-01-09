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

namespace App\Stock\Application\Command\InitializeProductStock;

use App\Stock\Domain\Product;
use App\Stock\Domain\ProductLocation;

final class InitializeProductStockCommand
{
    /**
     * @var Product
     */
    public Product $product;
    /**
     * @var ProductLocation
     */
    public ProductLocation $productLocation;

    public function __construct(Product $product, ProductLocation $productLocation)
    {
        $this->product = $product;
        $this->productLocation = $productLocation;
    }
}
