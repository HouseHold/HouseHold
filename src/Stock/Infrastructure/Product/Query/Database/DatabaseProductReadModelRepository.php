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

namespace App\Stock\Infrastructure\Product\Query\Database;

use App\Core\Infrastructure\Share\Query\Repository\DatabaseRepository;
use App\Stock\Domain\Product;
use App\Stock\Domain\Product\Exception\ProductNotFoundByNameException;
use App\Stock\Domain\Product\Repository\GetProductByName;
use Doctrine\ORM\EntityManagerInterface;

final class DatabaseProductReadModelRepository extends DatabaseRepository implements GetProductByName
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->class = Product::class;
        parent::__construct($entityManager);
    }

    /**
     * {@inheritdoc}
     */
    public function getProductByName(string $name): Product
    {
        /** @var Product|null $product */
        $product = $this->repository->findOneBy(['name' => $name]);

        if (null === $product) {
            throw new ProductNotFoundByNameException("Could not find product with name of $name.");
        }

        return $product;
    }
}
