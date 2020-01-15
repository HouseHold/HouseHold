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

namespace App\Stock\Application\Command\ConsumeProductFromStock;

use App\Core\Application\Command\SyncCommand;
use App\Core\Domain\Shared\ValueObject\DateTime;
use App\Stock\Domain\ProductStock;

final class ConsumeProductFromStockCommand implements SyncCommand
{
    public ProductStock $stock;
    public ?DateTime $bestBefore;
    public int $quantity;

    public function __construct(ProductStock $stock, ?DateTime $bestBefore, int $quantity)
    {
        $this->stock = $stock;
        $this->bestBefore = $bestBefore;
        $this->quantity = $quantity;
    }
}
