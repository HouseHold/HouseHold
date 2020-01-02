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

namespace App\Core\Application\Query\ExampleUser\FindByEmail;

use App\Core\Application\Query\Item;
use App\Core\Application\Query\QueryHandlerInterface;
use App\Core\Infrastructure\ExampleUser\Query\Mysql\MysqlExampleUserReadModelRepository;
use App\Core\Infrastructure\ExampleUser\Query\Projections\UserView;

class FindByEmailHandler implements QueryHandlerInterface
{
    /**
     * @throws \App\Core\Domain\Shared\Query\Exception\NotFoundException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function __invoke(FindByEmailQuery $query): Item
    {
        /** @var UserView $userView */
        $userView = $this->repository->oneByEmail($query->email);

        return new Item($userView);
    }

    public function __construct(MysqlExampleUserReadModelRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @var MysqlExampleUserReadModelRepository
     */
    private $repository;
}
