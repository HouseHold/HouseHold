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

namespace App\DataFixtures\Stock;

use App\Stock\Domain\Product;
use App\Stock\Domain\ProductCategory;
use App\Stock\Domain\ProductCollection;
use App\Stock\Domain\ProductLocation;
use App\Stock\Domain\ProductStock;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;

final class AAA_StockCleanupBeforeFixtures extends AbstractStockFixture
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * {@inheritdoc}
     *
     * @throws \Doctrine\DBAL\DBALException
     */
    public function load(ObjectManager $manager)
    {
        $tables = [
            ProductCategory::class,
            ProductCollection::class,
            Product::class,
            ProductLocation::class,
            ProductStock::class,
            ProductStock\ProductStockEvent::class,
        ];
        foreach ($tables as &$table) {
            $table = $this->em->getClassMetadata($table)->getTableName();
        }

        $con = $this->em->getConnection();
        $con->query('SET FOREIGN_KEY_CHECKS=0');
        foreach ($tables as $table) {
            $con->executeUpdate($con->getDatabasePlatform()->getTruncateTableSQL($table));
        }
        $con->query('SET FOREIGN_KEY_CHECKS=1');
    }
}
