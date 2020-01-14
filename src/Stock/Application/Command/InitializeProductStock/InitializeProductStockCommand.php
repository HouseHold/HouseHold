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

use App\Core\Application\Command\SyncCommand;
use App\Stock\Domain\Product;
use App\Stock\Domain\ProductLocation;

final class InitializeProductStockCommand implements SyncCommand
{
    public Product $product;
    public ProductLocation $productLocation;
    /**
     * @var callable
     */
    public $stockCallback;

    public function __construct(Product $product, ProductLocation $productLocation, ?callable $stockCallback = null)
    {
        $this->product = $product;
        $this->productLocation = $productLocation;
        $this->stockCallback = $stockCallback;
    }
}
