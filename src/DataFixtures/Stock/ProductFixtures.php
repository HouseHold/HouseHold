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
use App\Stock\Domain\ProductCollection;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

final class ProductFixtures extends AbstractDependentFixture
{
    protected const DEPS = [CategoryFixtures::class, CollectionFixtures::class];

    public const CG_1_PC_1_NAME_1 = 'Pantteri';
    public const CG_1_PC_1_NAME_2 = 'Tyrkisk Peber';
    public const CG_1_PC_1_NAME_3 = 'Lakrisal';
    public const CG_1_PC_1_NAME_4 = 'Pirate coins';

    public const CG_1_PC_2_NAME_1 = 'Läkerol';
    public const CG_1_PC_2_NAME_2 = 'Violets';
    public const CG_1_PC_2_NAME_3 = 'Mentos';
    public const CG_1_PC_2_NAME_4 = 'Jujube';

    public const CG_1_PC_3_NAME_1 = 'Cinnamon Calvados charm';
    public const CG_1_PC_3_NAME_2 = 'Centenario Concha';
    public const CG_1_PC_3_NAME_3 = 'Sour Gooseberries';
    public const CG_1_PC_3_NAME_4 = 'Salty caramel';

    public const CG_1_PC_4_NAME_1 = 'Caramel Fudge';
    public const CG_1_PC_4_NAME_2 = 'Liquorice Fudge';
    public const CG_1_PC_4_NAME_3 = 'Salted Fudge';
    public const CG_1_PC_4_NAME_4 = 'Buckeye Fudge';

    public const CG_1_PC_5_NAME_1 = 'Authentic Konpeitō';
    public const CG_1_PC_5_NAME_2 = 'Homemade Konpeitō';

    public const CG_2_PC_1_NAME_1 = 'Smirnoff';
    public const CG_2_PC_1_NAME_2 = 'Laplandia';

    public const CG_2_PC_2_NAME_1 = 'Kyrö Gin';
    public const CG_2_PC_2_NAME_2 = 'Helsinki Dry Gin';
    public const CG_2_PC_2_NAME_3 = 'Kyrö Koskue';
    public const CG_2_PC_2_NAME_4 = 'Kalevala Navy Gin';
    public const CG_2_PC_2_NAME_5 = 'London Dry Gin';
    public const CG_2_PC_2_NAME_6 = 'Artic Blue Gin';

    public const CG_2_PC_3_NAME_1 = 'Bruichladdich Black Art 1990';
    public const CG_2_PC_3_NAME_2 = 'Octomore 7.4';
    public const CG_2_PC_3_NAME_3 = 'Talisker 18';
    public const CG_2_PC_3_NAME_4 = 'Lagavulin 16';
    public const CG_2_PC_3_NAME_5 = 'Highland Park 18';
    public const CG_2_PC_3_NAME_6 = 'Jameson 18';
    public const CG_2_PC_3_NAME_7 = '6.12 Independence Day Port Charlotter 15';

    public const CG_2_PC_4_NAME_1 = 'Pasquinet Grande Champagne X.O.';
    public const CG_2_PC_4_NAME_2 = 'Hennessy X.O.';
    public const CG_2_PC_4_NAME_3 = 'Bache-Gabrielsen Finland 1917-2017';

    public const CG_2_PC_5_NAME_1 = 'Mount Gay XO';
    public const CG_2_PC_5_NAME_2 = 'Diplomático Ambassador';
    public const CG_2_PC_5_NAME_3 = 'Rammstein Rum';

    public const CG_3_PC_1_NAME_1 = 'Organic Milk';
    public const CG_3_PC_1_NAME_2 = 'Whole Milk';
    public const CG_3_PC_1_NAME_3 = 'Fat-free Milk';

    public const CG_3_PC_2_NAME_1 = 'Cranberry Juice';
    public const CG_3_PC_2_NAME_2 = 'Tomato Juice';
    public const CG_3_PC_2_NAME_3 = 'Apple Juice';
    public const CG_3_PC_2_NAME_4 = 'Orange Juice';

    public const CG_3_PC_3_NAME_1 = 'Red Bull';
    public const CG_3_PC_3_NAME_2 = 'Olvi';
    public const CG_3_PC_3_NAME_3 = 'Battery';
    public const CG_3_PC_3_NAME_4 = 'Pommac';

    public const CG_3_PC_4_NAME_1 = 'Expresso';
    public const CG_3_PC_4_NAME_2 = 'Cappuccino';
    public const CG_3_PC_4_NAME_3 = 'Macchiato';

    public const CG_3_PC_5_NAME_1 = 'White Tea';
    public const CG_3_PC_5_NAME_2 = 'Green Tea';
    public const CG_3_PC_5_NAME_3 = 'Black Tea';

    public const CG_4_PC_1_NAME_1 = 'Finnish MRE';
    public const CG_4_PC_1_NAME_2 = 'German MRE';
    public const CG_4_PC_1_NAME_3 = 'Swedish MRE';

    public const CG_4_PC_2_NAME_1 = 'Cellophane Noodles';
    public const CG_4_PC_2_NAME_2 = 'Asian Noodles';

    public const CG_4_PC_3_NAME_1 = 'Italian Pizza';
    public const CG_4_PC_3_NAME_2 = 'Finnish Pizza';

    public const CG_4_PC_4_NAME_1 = 'Homemade Cottage Pie';
    public const CG_4_PC_4_NAME_2 = 'Market Cottage Pie';

    public const CG_4_PC_5_NAME_1 = 'BirdsEyes Chicken Curry';
    public const CG_4_PC_5_NAME_2 = 'Pace Cheesy Chicken';

    public const CG_5_PC_1_NAME_1 = 'Farm Mint';
    public const CG_5_PC_1_NAME_2 = 'Store Mint';
    public const CG_5_PC_1_NAME_3 = 'Homemade Mint';

    public const CG_5_PC_2_NAME_1 = 'Farm Rosemary';
    public const CG_5_PC_2_NAME_2 = 'Store Rosemary';
    public const CG_5_PC_2_NAME_3 = 'Homemade Rosemary';

    public const CG_5_PC_3_NAME_1 = 'Farm Oregano';
    public const CG_5_PC_3_NAME_2 = 'Store Oregano';
    public const CG_5_PC_3_NAME_3 = 'Homemade Oregano';

    public const CG_5_PC_4_NAME_1 = 'Farm Parsley';
    public const CG_5_PC_4_NAME_2 = 'Store Parsley';
    public const CG_5_PC_4_NAME_3 = 'Homemade Parsley';

    public const CG_5_PC_5_NAME_1 = 'Farm Peppermint';
    public const CG_5_PC_5_NAME_2 = 'Store Peppermint';
    public const CG_5_PC_5_NAME_3 = 'Homemade Peppermint';

    public const ALL =
        [
            CategoryFixtures::NAME_1 => [
                    CollectionFixtures::CG_1_NAME_1 => [
                            self::CG_1_PC_1_NAME_1,
                            self::CG_1_PC_1_NAME_2,
                            self::CG_1_PC_1_NAME_3,
                            self::CG_1_PC_1_NAME_4,
                    ],
                    CollectionFixtures::CG_1_NAME_2 => [
                            self::CG_1_PC_2_NAME_1,
                            self::CG_1_PC_2_NAME_2,
                            self::CG_1_PC_2_NAME_3,
                            self::CG_1_PC_2_NAME_4,
                        ],
                    CollectionFixtures::CG_1_NAME_3 => [
                            self::CG_1_PC_3_NAME_1,
                            self::CG_1_PC_3_NAME_2,
                            self::CG_1_PC_3_NAME_3,
                            self::CG_1_PC_3_NAME_4,
                        ],
                    CollectionFixtures::CG_1_NAME_4 => [
                            self::CG_1_PC_4_NAME_1,
                            self::CG_1_PC_4_NAME_2,
                            self::CG_1_PC_4_NAME_3,
                            self::CG_1_PC_4_NAME_4,
                        ],
                    CollectionFixtures::CG_1_NAME_5 => [
                            self::CG_1_PC_5_NAME_1,
                            self::CG_1_PC_5_NAME_2,
                        ],
                ],
            CategoryFixtures::NAME_2 => [
                    CollectionFixtures::CG_2_NAME_1 => [
                            self::CG_2_PC_1_NAME_1,
                            self::CG_2_PC_1_NAME_2,
                        ],
                    CollectionFixtures::CG_2_NAME_2 => [
                            self::CG_2_PC_2_NAME_1,
                            self::CG_2_PC_2_NAME_2,
                            self::CG_2_PC_2_NAME_3,
                            self::CG_2_PC_2_NAME_4,
                            self::CG_2_PC_2_NAME_5,
                            self::CG_2_PC_2_NAME_6,
                        ],
                    CollectionFixtures::CG_2_NAME_3 => [
                            self::CG_2_PC_3_NAME_1,
                            self::CG_2_PC_3_NAME_2,
                            self::CG_2_PC_3_NAME_3,
                            self::CG_2_PC_3_NAME_4,
                            self::CG_2_PC_3_NAME_5,
                            self::CG_2_PC_3_NAME_6,
                            self::CG_2_PC_3_NAME_7,
                        ],
                    CollectionFixtures::CG_2_NAME_4 => [
                            self::CG_2_PC_4_NAME_1,
                            self::CG_2_PC_4_NAME_2,
                            self::CG_2_PC_4_NAME_3,
                        ],
                    CollectionFixtures::CG_2_NAME_5 => [
                            self::CG_2_PC_5_NAME_1,
                            self::CG_2_PC_5_NAME_2,
                            self::CG_2_PC_5_NAME_3,
                        ],
                ],
                CategoryFixtures::NAME_3 => [
                    CollectionFixtures::CG_3_NAME_1 => [
                            self::CG_3_PC_1_NAME_1,
                            self::CG_3_PC_1_NAME_2,
                            self::CG_3_PC_1_NAME_3,
                        ],
                    CollectionFixtures::CG_3_NAME_2 => [
                            self::CG_3_PC_2_NAME_1,
                            self::CG_3_PC_2_NAME_2,
                            self::CG_3_PC_2_NAME_3,
                            self::CG_3_PC_2_NAME_4,
                        ],
                    CollectionFixtures::CG_3_NAME_3 => [
                            self::CG_3_PC_3_NAME_1,
                            self::CG_3_PC_3_NAME_2,
                            self::CG_3_PC_3_NAME_3,
                            self::CG_3_PC_3_NAME_4,
                        ],
                    CollectionFixtures::CG_3_NAME_4 => [
                            self::CG_3_PC_4_NAME_1,
                            self::CG_3_PC_4_NAME_2,
                            self::CG_3_PC_4_NAME_3,
                        ],
                    CollectionFixtures::CG_3_NAME_5 => [
                            self::CG_3_PC_5_NAME_1,
                            self::CG_3_PC_5_NAME_2,
                            self::CG_3_PC_5_NAME_3,
                        ],
                    ],
            CategoryFixtures::NAME_4 => [
                    CollectionFixtures::CG_4_NAME_1 => [
                            self::CG_4_PC_1_NAME_1,
                            self::CG_4_PC_1_NAME_2,
                            self::CG_4_PC_1_NAME_3,
                        ],
                    CollectionFixtures::CG_4_NAME_2 => [
                            self::CG_4_PC_2_NAME_1,
                            self::CG_4_PC_2_NAME_2,
                        ],
                    CollectionFixtures::CG_4_NAME_3 => [
                            self::CG_4_PC_3_NAME_1,
                            self::CG_4_PC_3_NAME_2,
                        ],
                    CollectionFixtures::CG_4_NAME_4 => [
                            self::CG_4_PC_4_NAME_1,
                            self::CG_4_PC_4_NAME_2,
                        ],
                    CollectionFixtures::CG_4_NAME_5 => [
                            self::CG_4_PC_5_NAME_1,
                            self::CG_4_PC_5_NAME_2,
                        ],
                ],
            CategoryFixtures::NAME_5 => [
                    CollectionFixtures::CG_5_NAME_1 => [
                            self::CG_5_PC_1_NAME_1,
                            self::CG_5_PC_1_NAME_2,
                            self::CG_5_PC_1_NAME_3,
                        ],
                    CollectionFixtures::CG_5_NAME_2 => [
                            self::CG_5_PC_2_NAME_1,
                            self::CG_5_PC_2_NAME_2,
                            self::CG_5_PC_2_NAME_3,
                        ],
                    CollectionFixtures::CG_5_NAME_3 => [
                            self::CG_5_PC_3_NAME_1,
                            self::CG_5_PC_3_NAME_2,
                            self::CG_5_PC_3_NAME_3,
                        ],
                    CollectionFixtures::CG_5_NAME_4 => [
                            self::CG_5_PC_4_NAME_1,
                            self::CG_5_PC_4_NAME_2,
                            self::CG_5_PC_4_NAME_3,
                        ],
                    CollectionFixtures::CG_5_NAME_5 => [
                            self::CG_5_PC_5_NAME_1,
                            self::CG_5_PC_5_NAME_2,
                            self::CG_5_PC_5_NAME_3,
                        ],
                ],
        ];

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $f = Factory::create();

        foreach (self::ALL as $categoryName => $collections) {
            foreach ($collections as $c => $products) {
                /** @var ProductCollection $collection */
                $collection = $manager->getRepository(ProductCollection::class)->findOneBy(['name' => $c]);
                foreach ($products as $product) {
                    $manager->persist(new Product(
                        $product,
                        [$f->ean8, $f->ean13],
                        $f->randomFloat(2, 0.5, 100),
                        $f->boolean(50),
                        $f->dateTimeBetween('-3 months', '+9 months'),
                        $collection,
                    ));
                }
            }
            $manager->flush();
        }
    }
}
