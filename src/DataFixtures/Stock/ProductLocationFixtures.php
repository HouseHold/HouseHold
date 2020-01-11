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

use App\Stock\Domain\ProductLocation;
use Doctrine\Common\Persistence\ObjectManager;

final class ProductLocationFixtures extends AbstractStockFixture
{
    public const NAME_1 = 'Freezer';
    public const NAME_2 = 'Fridge';
    public const NAME_3 = 'Island';
    public const NAME_4 = 'Upper Cabinet';
    public const NAME_5 = 'Storage Cabinet';
    public const ALL = [self::NAME_1, self::NAME_2, self::NAME_3, self::NAME_4, self::NAME_5];

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        foreach (self::ALL as $location) {
            $manager->persist($ref = new ProductLocation($location));
        }
        $manager->flush();
    }
}
