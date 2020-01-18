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

namespace App\Stock\Infrastructure\ProductStock\Repository\Database;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\PaginationExtension;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGenerator;
use ApiPlatform\Core\DataProvider\CollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Stock\Application\Query\GetStockBestBefore\GetStockBestBeforeQuery;
use App\Stock\Domain\ProductStock;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

final class ApiProductStockDataProvider implements CollectionDataProviderInterface, RestrictedDataProviderInterface
{
    private ManagerRegistry $registry;
    private PaginationExtension $pagination;
    private array $context;
    private MessageBusInterface $queryBus;

    public function __construct(
        ManagerRegistry $registry,
        PaginationExtension $pagination,
        MessageBusInterface $queryBus
    ) {
        $this->registry = $registry;
        $this->pagination = $pagination;
        $this->queryBus = $queryBus;
    }

    /**
     * {@inheritdoc}
     */
    public function getCollection(string $resourceClass, string $operationName = null)
    {
        /** @var QueryBuilder $query */
        $query = $this->registry
            ->getManagerForClass($resourceClass)
            ->getRepository($resourceClass)
            ->createQueryBuilder('ps');

        $this->pagination->applyToCollection(
            $query,
            new QueryNameGenerator(),
            $resourceClass,
            $operationName,
            $this->context
        );

        /** @var ProductStock[] $results */
        $results = $query->getQuery()->getResult();
        foreach ($results as &$result) {
            if (true === $result->product->expiring) {
                $result->bestBefore = $this->queryBus
                    ->dispatch(new GetStockBestBeforeQuery($result->getId()))
                    ->last(HandledStamp::class)->getResult();
            }
        }

        return $results;
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        if (ProductStock::class === $resourceClass
            && 'get' === $operationName
            && 'collection' === $context['operation_type']
        ) {
            $this->context = $context;

            return true;
        }

        return false;
    }
}
