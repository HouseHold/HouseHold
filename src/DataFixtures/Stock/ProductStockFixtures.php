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
use Doctrine\Common\Persistence\ObjectManager;
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
        foreach (ProductFixtures::ALL as $categoryName => $collections) {
            foreach ($collections as $collectionName => $products) {
                foreach ($products as $product) {
                    /** @var $location PL */
                    /** @var $product Product */
                    $product = $manager->getRepository(Product::class)->findOneBy(['name' => $product]);
                    $location = $manager->getRepository(PL::class)->findOneBy(['name' => PLF::ALL[rand(0, 4)]]);
                    $stock = null;
                    $this->commandBus->dispatch(new InitializeProductStockCommand(
                        $product,
                        $location,
                        function (ProductStock $s) use (&$stock) {$stock = $s; }
                    ));
                    $this->commandBus->dispatch(new AddProductToStockCommand(
                        $stock,
                        DateTime::fromString($product->bestBefore->format(DATE_ATOM)),
                        rand(1, 20)
                    ));
                }
            }
        }
    }
}
