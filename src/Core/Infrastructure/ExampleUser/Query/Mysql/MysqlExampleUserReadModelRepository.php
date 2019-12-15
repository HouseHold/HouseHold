<?php

declare(strict_types=1);

/**
 *
 * Household 2019 — NOTICE OF LICENSE
 * This source file is released under commercial license by copyright holders.
 *
 * @copyright 2017-2019 (c) Niko Granö (https://granö.fi)
 * @copyright 2014-2019 (c) IronLions (https://ironlions.fi)
 *
 */

namespace App\Core\Infrastructure\ExampleUser\Query\Mysql;

use App\Core\Domain\ExampleUser\Repository\CheckExampleUserByEmailInterface;
use App\Core\Domain\ExampleUser\Repository\GetExampleUserCredentialsByEmailInterface;
use App\Core\Domain\ExampleUser\ValueObject\Email;
use App\Core\Infrastructure\ExampleUser\Query\Projections\ExampleUserView;
use App\Core\Infrastructure\Share\Query\Repository\MysqlRepository;
use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\UuidInterface;

final class MysqlExampleUserReadModelRepository extends MysqlRepository implements CheckExampleUserByEmailInterface, GetExampleUserCredentialsByEmailInterface
{
    /**
     * @throws \App\Core\Domain\Shared\Query\Exception\NotFoundException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function oneByUuid(UuidInterface $uuid): UserView
    {
        $qb = $this->repository
            ->createQueryBuilder('user')
            ->where('user.uuid = :uuid')
            ->setParameter('uuid', $uuid->getBytes())
        ;

        return $this->oneOrException($qb);
    }

    /**
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function existsEmail(Email $email): ?UuidInterface
    {
        $userId = $this->repository
            ->createQueryBuilder('user')
            ->select('user.uuid')
            ->where('user.credentials.email = :email')
            ->setParameter('email', (string) $email)
            ->getQuery()
            ->setHydrationMode(AbstractQuery::HYDRATE_ARRAY)
            ->getOneOrNullResult()
        ;

        return $userId['uuid'] ?? null;
    }

    /**
     * @throws \App\Core\Domain\Shared\Query\Exception\NotFoundException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function oneByEmail(Email $email): UserView
    {
        $qb = $this->repository
            ->createQueryBuilder('user')
            ->where('user.credentials.email = :email')
            ->setParameter('email', $email->toString())
        ;

        return $this->oneOrException($qb);
    }

    public function add(ExampleUserView $userRead): void
    {
        $this->register($userRead);
    }

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->class = UserView::class;
        parent::__construct($entityManager);
    }

    /**
     * @throws \App\Core\Domain\Shared\Query\Exception\NotFoundException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getCredentialsByEmail(Email $email): array
    {
        $user = $this->oneByEmail($email);

        return [
            $user->uuid(),
            $user->email(),
            $user->hashedPassword(),
        ];
    }
}
