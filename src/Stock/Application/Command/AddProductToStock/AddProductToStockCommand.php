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

namespace App\Stock\Application\Command\AddProductToStock;

use App\Core\Domain\Shared\ValueObject\DateTime;
use App\Stock\Domain\Product;
use App\Stock\Domain\ProductLocation;

final class AddProductToStockCommand
{
    /**
     * @var Product
     */
    private Product $product;
    /**
     * @var DateTime
     */
    private DateTime $bestBefore;
    /**
     * @var int
     */
    private int $amount;
    /**
     * @var ProductLocation
     */
    private ProductLocation $location;

    public function __construct(
        Product $product,
        DateTime $bestBefore,
        int $amount,
        ProductLocation $location
    ) {
        $this->product = $product;
        $this->bestBefore = $bestBefore;
        $this->amount = $amount;
        $this->location = $location;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function getBestBefore(): DateTime
    {
        return $this->bestBefore;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function getLocation(): ProductLocation
    {
        return $this->location;
    }
}
