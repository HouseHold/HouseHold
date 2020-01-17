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

namespace App\Stock\Application\Query\GetStockBestBefore;

use App\Core\Application\Query\QueryHandlerInterface;
use App\Stock\Domain\ProductStock\Repository\ProductStockStoreRepository;

final class GetStockBestBeforeHandler implements QueryHandlerInterface
{
    /**
     * @var ProductStockStoreRepository
     */
    private ProductStockStoreRepository $repo;

    public function __construct(ProductStockStoreRepository $repo)
    {
        $this->repo = $repo;
    }

    public function __invoke(GetStockBestBeforeQuery $query): array
    {
        return $this->repo->get($query->id)->getBestBefore();
    }
}
