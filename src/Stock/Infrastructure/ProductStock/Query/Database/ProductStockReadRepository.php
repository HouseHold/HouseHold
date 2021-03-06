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

namespace App\Stock\Infrastructure\ProductStock\Query\Database;

use App\Core\Infrastructure\Share\Query\Repository\DatabaseRepository;
use App\Stock\Domain\Product;
use App\Stock\Domain\ProductLocation;
use App\Stock\Domain\ProductStock;
use App\Stock\Domain\ProductStock\Exception\ProductStockNotFoundByIdException as NotFoundById;
use App\Stock\Domain\ProductStock\Exception\ProductStockNotFoundByNameAndLocationException as NotFoundByNameAndLocation;
use App\Stock\Domain\ProductStock\Repository\GetProductStockById;
use App\Stock\Domain\ProductStock\Repository\GetProductStockByProductAndLocation;
use Ramsey\Uuid\UuidInterface;

final class ProductStockReadRepository extends DatabaseRepository implements GetProductStockByProductAndLocation, GetProductStockById
{
    protected string $class = ProductStock::class;

    /**
     * {@inheritdoc}
     */
    public function getProductStockByProductAndLocation(Product $product, ProductLocation $location): ProductStock
    {
        /** @var ProductStock|null $stock */
        $stock = $this->repository->findOneBy(['product' => $product, 'location' => $location]);

        if (null === $stock) {
            throw new NotFoundByNameAndLocation(sprintf('Could not find product stock for product %s (%s) and location %s (%s).', $product->name, $product->getId(), $location->name, $location->getId()));
        }

        return $stock;
    }

    /**
     * @throws NotFoundById
     */
    public function getProductStockById(UuidInterface $id): ProductStock
    {
        /** @var ProductStock|null $stock */
        $stock = $this->repository->find($id);

        if (null === $stock) {
            throw new NotFoundById(sprintf('Could not find product stock by id (%s).', $id->toString()));
        }

        return $stock;
    }
}
