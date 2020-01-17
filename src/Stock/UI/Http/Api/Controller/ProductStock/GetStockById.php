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

namespace App\Stock\UI\Http\Api\Controller\ProductStock;

use App\Core\UI\Http\Web\Controller\AbstractController;
use App\Stock\Application\Query\GetStock\GetStockQuery;
use App\Stock\Application\Query\GetStockBestBefore\GetStockBestBeforeQuery;
use App\Stock\Domain\ProductStock;
use App\Stock\Domain\ProductStock\Exception\ProductStockNotFoundByIdException as NotFound;
use Ramsey\Uuid\Uuid;

final class GetStockById extends AbstractController
{
    public function __invoke(string $id): ProductStock
    {
        try {
            /** @var ProductStock $stock */
            $stock = $this->ask(new GetStockQuery(Uuid::fromString($id)));
        } catch (NotFound $e) {
            $this->returnForException($e, 404);
        }

        if ($stock->product->expiring) {
            $stock->bestBefore = $this->ask(new GetStockBestBeforeQuery($stock->getId()));
        }

        return $stock;
    }
}
