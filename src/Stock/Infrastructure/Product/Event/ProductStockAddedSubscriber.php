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

namespace App\Stock\Infrastructure\Product\Event;

use App\Stock\Domain\Product;
use App\Stock\Domain\ProductStock\Event\ProductAddedToStock;
use App\Stock\Domain\ProductStock\Event\ProductStockEventApplied;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

final class ProductStockAddedSubscriber implements EventSubscriberInterface
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents(): array
    {
        return [ProductStockEventApplied::class => 'onStockEventApplied'];
    }

    /**
     * @throws \Doctrine\ORM\ORMException
     */
    public function onStockEventApplied(ProductStockEventApplied $event): void
    {
        if ($event->event instanceof ProductAddedToStock) {
            $product = $this->em->getReference(Product::class, $event->aggregateRoot->getProduct());
            $product->price = $event->event->price;
            $this->em->flush();
        }
    }
}
