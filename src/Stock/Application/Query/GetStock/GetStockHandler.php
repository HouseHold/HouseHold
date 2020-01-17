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

namespace App\Stock\Application\Query\GetStock;

use App\Core\Application\Query\QueryHandlerInterface;
use App\Stock\Domain\ProductStock;
use App\Stock\Domain\ProductStock\Repository\GetProductStockById;

final class GetStockHandler implements QueryHandlerInterface
{
    /**
     * @var GetProductStockById
     */
    private GetProductStockById $repo;

    public function __construct(GetProductStockById $repo)
    {
        $this->repo = $repo;
    }

    /**
     * @throws ProductStock\Exception\ProductStockNotFoundByIdException
     */
    public function __invoke(GetStockQuery $query): ProductStock
    {
        return $this->repo->getProductStockById($query->id);
    }
}
