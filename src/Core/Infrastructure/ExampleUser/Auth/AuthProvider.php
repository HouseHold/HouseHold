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

namespace App\Core\Infrastructure\ExampleUser\Auth;

use App\Core\Domain\ExampleUser\ValueObject\Email;
use App\Core\Infrastructure\ExampleUser\Query\Mysql\MysqlExampleUserReadModelRepository;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class AuthProvider implements UserProviderInterface
{
    /**
     * @param string $email
     *
     * @throws \App\Core\Domain\Shared\Query\Exception\NotFoundException
     * @throws \Assert\AssertionFailedException
     * @throws \Doctrine\ORM\NonUniqueResultException
     *
     * @return Auth|UserInterface
     */
    public function loadUserByUsername($email)
    {
        // @var array $user
        [$uuid, $email, $hashedPassword] = $this->userReadModelRepository->getCredentialsByEmail(
            Email::fromString($email)
        );

        return Auth::create($uuid, $email, $hashedPassword);
    }

    /**
     * @throws \App\Core\Domain\Shared\Query\Exception\NotFoundException
     * @throws \Assert\AssertionFailedException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function refreshUser(UserInterface $user): UserInterface
    {
        return $this->loadUserByUsername($user->getUsername());
    }

    public function supportsClass($class): bool
    {
        return Auth::class === $class;
    }

    public function __construct(MysqlExampleUserReadModelRepository $userReadModelRepository)
    {
        $this->userReadModelRepository = $userReadModelRepository;
    }

    /**
     * @var MysqlExampleUserReadModelRepository
     */
    private $userReadModelRepository;
}
