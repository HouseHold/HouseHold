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

namespace App\Core\Infrastructure\Share\Query\Repository;

use App\Core\Domain\Shared\Query\Exception\NotFoundException;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\QueryBuilder;

abstract class DatabaseRepository
{
    protected string $class;
    protected EntityRepository $repository;
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
        $this->setRepository($this->class);
    }

    public function register($model): void
    {
        $this->em->persist($model);
        $this->apply();
    }

    public function apply(): void
    {
        $this->em->flush();
    }

    /**
     * @throws NotFoundException
     * @throws NonUniqueResultException
     */
    protected function oneOrException(QueryBuilder $queryBuilder)
    {
        $model = $queryBuilder
            ->getQuery()
            ->getOneOrNullResult()
        ;

        if (null === $model) {
            throw new NotFoundException();
        }

        return $model;
    }

    private function setRepository(string $model): void
    {
        /** @var EntityRepository $objectRepository */
        $objectRepository = $this->em->getRepository($model);
        $this->repository = $objectRepository;
    }
}
