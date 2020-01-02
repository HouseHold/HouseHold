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

namespace App\Core\Application\Command\ExampleUser\ChangeEmail;

use App\Core\Application\Command\CommandHandlerInterface;
use App\Core\Domain\ExampleUser\Repository\ExampleUserRepositoryInterface;
use App\Core\Domain\ExampleUser\Specification\UniqueEmailSpecificationInterface;

class ChangeEmailHandler implements CommandHandlerInterface
{
    public function __invoke(ChangeEmailCommand $command): void
    {
        $user = $this->exampleUserRepository->get($command->userUuid);

        $user->changeEmail($command->email, $this->uniqueEmailSpecification);

        $this->exampleUserRepository->store($user);
    }

    public function __construct(
        ExampleUserRepositoryInterface $exampleUserRepository,
        UniqueEmailSpecificationInterface $uniqueEmailSpecification
    ) {
        $this->exampleUserRepository = $exampleUserRepository;
        $this->uniqueEmailSpecification = $uniqueEmailSpecification;
    }

    /**
     * @var ExampleUserRepositoryInterface
     */
    private $exampleUserRepository;

    /**
     * @var UniqueEmailSpecificationInterface
     */
    private $uniqueEmailSpecification;
}
