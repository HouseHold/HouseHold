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

use App\Stock\Domain\ProductCategory;
use Doctrine\Common\Persistence\ObjectManager;

final class CategoryFixtures extends AbstractStockFixture
{
    public const NAME_1 = 'Sweets';
    public const NAME_2 = 'Alcohol';
    public const NAME_3 = 'Drinks';
    public const NAME_4 = 'Meals';
    public const NAME_5 = 'Herbs';
    public const ALL = [self::NAME_1, self::NAME_2, self::NAME_3, self::NAME_4, self::NAME_5];

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        foreach (self::ALL as $category) {
            $manager->persist(new ProductCategory($category));
        }
        $manager->flush();
    }
}
