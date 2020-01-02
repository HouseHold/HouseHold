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

namespace App\Core\Infrastructure\ExampleUser\Query;

use App\Core\Domain\ExampleUser\Event\UserEmailChanged;
use App\Core\Domain\ExampleUser\Event\UserWasCreated;
use App\Core\Infrastructure\ExampleUser\Query\Mysql\MysqlExampleUserReadModelRepository;
use Broadway\ReadModel\Projector;

class ExampleUserProjectionFactory extends Projector
{
    /**
     * @throws \Assert\AssertionFailedException
     */
    protected function applyUserWasCreated(UserWasCreated $userWasCreated): void
    {
        $userReadModel = UserView::fromSerializable($userWasCreated);

        $this->repository->add($userReadModel);
    }

    /**
     * @throws \App\Core\Domain\Shared\Query\Exception\NotFoundException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    protected function applyUserEmailChanged(UserEmailChanged $emailChanged): void
    {
        /** @var UserView $userReadModel */
        $userReadModel = $this->repository->oneByUuid($emailChanged->uuid);

        $userReadModel->changeEmail($emailChanged->email);
        $userReadModel->changeUpdatedAt($emailChanged->updatedAt);

        $this->repository->apply();
    }

    public function __construct(MysqlExampleUserReadModelRepository $repository)
    {
        $this->repository = $repository;
    }

    /** @var MysqlExampleUserReadModelRepository */
    private $repository;
}
