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

use App\Core\Application\Command\SyncCommand;
use App\Core\Domain\Shared\ValueObject\DateTime;
use App\Stock\Domain\ProductStock;

final class AddProductToStockCommand implements SyncCommand
{
    public ProductStock $stock;
    public DateTime $bestBefore;
    public int $amount;

    public function __construct(
        ProductStock $stock,
        DateTime $bestBefore,
        int $amount
    ) {
        $this->bestBefore = $bestBefore;
        $this->amount = $amount;
        $this->stock = $stock;
    }
}
