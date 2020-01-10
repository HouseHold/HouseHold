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

namespace App\Stock\Infrastructure\ProductStock\Event;

use App\Stock\Domain\Product;
use App\Stock\Domain\ProductLocation;
use App\Stock\Domain\ProductStock;
use App\Stock\Domain\ProductStock\Event\ProductStockEventApplied;
use App\Stock\Domain\ProductStock\Repository\GetProductStockByProductAndLocation as StockFinder;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Contracts\EventDispatcher\Event;

final class ProductStockSubscriber implements EventSubscriberInterface
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $em;
    /**
     * @var StockFinder
     */
    private StockFinder $stockFinder;

    public function __construct(EntityManagerInterface $em, StockFinder $stockFinder)
    {
        $this->em = $em;
        $this->stockFinder = $stockFinder;
    }

    /**
     * @param Event|ProductStockEventApplied $event
     *
     * @throws ProductStock\Exception\ProductStockNotFoundByNameAndLocationException
     */
    public function onStockEventApplied(Event $event): void
    {
        $product = $this->em
            ->getRepository(Product::class)
            ->findOneBy(['id' => $event->aggregateRoot->getProduct()]);
        $location = $this->em
            ->getRepository(ProductLocation::class)
            ->findOneBy(['id' => $event->aggregateRoot->getLocation()]);
        $stock = $this->stockFinder->getProductStockByProductAndLocation($product, $location);
        $stock->quantity = $event->aggregateRoot->getQuantity();
        $this->em->persist($stock);
        $this->em->flush();
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents(): array
    {
        return [ProductStockEventApplied::class => 'onStockEventApplied'];
    }
}
