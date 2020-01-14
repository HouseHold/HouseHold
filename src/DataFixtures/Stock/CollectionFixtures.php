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
use App\Stock\Domain\ProductCollection;
use Doctrine\Persistence\ObjectManager;

final class CollectionFixtures extends AbstractDependentFixture
{
    protected const DEPS = [CategoryFixtures::class];

    public const CG_1_NAME_1 = 'Salmiak';
    public const CG_1_NAME_2 = 'Pastille';
    public const CG_1_NAME_3 = 'Chocolate';
    public const CG_1_NAME_4 = 'Fudge';
    public const CG_1_NAME_5 = 'Konpeitō';

    public const CG_2_NAME_1 = 'Vodka';
    public const CG_2_NAME_2 = 'Gin';
    public const CG_2_NAME_3 = 'Whiskey';
    public const CG_2_NAME_4 = 'Cognac';
    public const CG_2_NAME_5 = 'Rum';

    public const CG_3_NAME_1 = 'Milk';
    public const CG_3_NAME_2 = 'Juice';
    public const CG_3_NAME_3 = 'Soft Dink';
    public const CG_3_NAME_4 = 'Coffee';
    public const CG_3_NAME_5 = 'Tea';

    public const CG_4_NAME_1 = 'Military MRE';
    public const CG_4_NAME_2 = 'Cup Noodles';
    public const CG_4_NAME_3 = 'Frozen Pizza';
    public const CG_4_NAME_4 = 'Cottage Pie';
    public const CG_4_NAME_5 = 'Rice & Chicken';

    public const CG_5_NAME_1 = 'Mint';
    public const CG_5_NAME_2 = 'Rosemary';
    public const CG_5_NAME_3 = 'Oregano';
    public const CG_5_NAME_4 = 'Parsley';
    public const CG_5_NAME_5 = 'Peppermint';

    public const ALL_CG =
        [
            CategoryFixtures::NAME_1 => [
                self::CG_1_NAME_1,
                self::CG_1_NAME_2,
                self::CG_1_NAME_3,
                self::CG_1_NAME_4,
                self::CG_1_NAME_5,
            ],
            CategoryFixtures::NAME_2 => [
                self::CG_2_NAME_1,
                self::CG_2_NAME_2,
                self::CG_2_NAME_3,
                self::CG_2_NAME_4,
                self::CG_2_NAME_5,
            ],
            CategoryFixtures::NAME_3 => [
                self::CG_3_NAME_1,
                self::CG_3_NAME_2,
                self::CG_3_NAME_3,
                self::CG_3_NAME_4,
                self::CG_3_NAME_5,
            ],
            CategoryFixtures::NAME_4 => [
                self::CG_4_NAME_1,
                self::CG_4_NAME_2,
                self::CG_4_NAME_3,
                self::CG_4_NAME_4,
                self::CG_4_NAME_5,
            ],
            CategoryFixtures::NAME_5 => [
                self::CG_5_NAME_1,
                self::CG_5_NAME_2,
                self::CG_5_NAME_3,
                self::CG_5_NAME_4,
                self::CG_5_NAME_5,
            ],
        ];

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        foreach (self::ALL_CG as $category => $items) {
            /** @var ProductCategory $category */
            $category = $manager->getRepository(ProductCategory::class)->findOneBy(['name' => $category]);
            foreach ($items as $item) {
                $manager->persist(new ProductCollection($item, $category));
            }
        }
        $manager->flush();
    }
}
