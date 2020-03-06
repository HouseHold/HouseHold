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

use App\Core\Domain\Shared\ValueObject\DateTime;
use App\DataFixtures\Stock\ProductLocationFixtures as PLF;
use App\Stock\Application\Command\AddProductToStock\AddProductToStockCommand;
use App\Stock\Application\Command\InitializeProductStock\InitializeProductStockCommand;
use App\Stock\Domain\Product;
use App\Stock\Domain\ProductLocation as PL;
use App\Stock\Domain\ProductStock;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Messenger\MessageBusInterface;

final class ProductStockFixtures extends AbstractDependentFixture
{
    protected const DEPS =
        [
            CategoryFixtures::class,
            CollectionFixtures::class,
            ProductFixtures::class,
            ProductLocationFixtures::class,
        ];

    private MessageBusInterface $commandBus;

    public function __construct(MessageBusInterface $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * {@inheritdoc}
     *
     * @throws \App\Core\Domain\Shared\Exception\DateTimeException
     */
    public function load(ObjectManager $manager)
    {
        $f = Factory::create();
        foreach (ProductFixtures::ALL as $categoryName => $collections) {
            foreach ($collections as $collectionName => $products) {
                foreach ($products as $product) {
                    /** @var $location PL */
                    /** @var $product Product */
                    $product = $manager->getRepository(Product::class)->findOneBy(['name' => $product]);
                    $tRand = rand(1, 4);
                    $locationNames = PLF::ALL;
                    for ($t = 0; $t < $tRand; ++$t) {
                        $locationName = $locationNames[rand(0, (\count($locationNames) - 1))];
                        unset($locationNames[$locationName]);
                        $location = $manager->getRepository(PL::class)->findOneBy(['name' => $locationName]);
                        $stock = null;
                        $this->commandBus->dispatch(new InitializeProductStockCommand(
                            $product,
                            $location,
                            function (ProductStock $s) use (&$stock) { $stock = $s; }
                        ));
                        $manager->refresh($stock);
                        $for = rand(1, 3);
                        for ($i = 0; $i < $for; ++$i) {
                            $productBestBeforeOrNull = $product->expiring
                                ? DateTime::fromString($f->dateTimeBetween('-2 months', '+11 months')->format(DATE_ATOM))
                                : null;
                            $this->commandBus->dispatch(new AddProductToStockCommand(
                                $stock,
                                $productBestBeforeOrNull,
                                rand(1, 10),
                                rand(1, 10) <= 5 ?
                                    $product->price - $f->randomFloat(2, 0, 5)
                                    : $product->price + $f->randomFloat(2, 0, 5)
                            ));
                        }
                    }
                }
            }
        }
    }
}
