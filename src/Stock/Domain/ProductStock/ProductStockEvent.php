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

namespace App\Stock\Domain\ProductStock;

use App\Core\Infrastructure\Share\Event\Repository\ORM\AbstractEventStoreEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="stock_inventory_events")
 */
class ProductStockEvent extends AbstractEventStoreEntity
{
}
