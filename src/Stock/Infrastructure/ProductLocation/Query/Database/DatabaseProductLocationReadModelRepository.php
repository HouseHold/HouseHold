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

namespace App\Stock\Infrastructure\ProductLocation\Query\Database;

use App\Core\Infrastructure\Share\Query\Repository\DatabaseRepository;
use App\Stock\Domain\ProductLocation;
use App\Stock\Domain\ProductLocation\Exception\ProductLocationNotFoundByNameException;
use App\Stock\Domain\ProductLocation\Repository\GetProductLocationByName;
use Doctrine\ORM\EntityManagerInterface;

final class DatabaseProductLocationReadModelRepository extends DatabaseRepository implements GetProductLocationByName
{
    protected string $class = ProductLocation::class;

    /**
     * {@inheritdoc}
     */
    public function getProductLocationByName(string $name): ProductLocation
    {
        /** @var ProductLocation|null $product */
        $product = $this->repository->findOneBy(['name' => $name]);

        if (null === $product) {
            throw new ProductLocationNotFoundByNameException("Could not find product location with name of $name.");
        }

        return $product;
    }
}
