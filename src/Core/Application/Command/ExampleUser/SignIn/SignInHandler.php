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

namespace App\Core\Application\Command\ExampleUser\SignIn;

use App\Core\Application\Command\CommandHandlerInterface;
use App\Core\Domain\ExampleUser\Exception\InvalidCredentialsException;
use App\Core\Domain\ExampleUser\Repository\CheckExampleUserByEmailInterface;
use App\Core\Domain\ExampleUser\Repository\ExampleUserRepositoryInterface;
use App\Core\Domain\ExampleUser\ValueObject\Email;
use Ramsey\Uuid\UuidInterface;

class SignInHandler implements CommandHandlerInterface
{
    public function __invoke(SignInCommand $command): void
    {
        $uuid = $this->uuidFromEmail($command->email);

        $user = $this->userStore->get($uuid);

        $user->signIn($command->plainPassword);

        $this->userStore->store($user);
    }

    private function uuidFromEmail(Email $email): UuidInterface
    {
        $uuid = $this->userCollection->existsEmail($email);

        if (null === $uuid) {
            throw new InvalidCredentialsException();
        }

        return $uuid;
    }

    public function __construct(ExampleUserRepositoryInterface $userStore, CheckExampleUserByEmailInterface $userCollection)
    {
        $this->userStore = $userStore;
        $this->userCollection = $userCollection;
    }

    /**
     * @var ExampleUserRepositoryInterface
     */
    private $userStore;

    /**
     * @var CheckExampleUserByEmailInterface
     */
    private $userCollection;
}
