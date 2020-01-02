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

namespace App\Core\Application\Command\ExampleUser\SignUp;

use App\Core\Application\Command\CommandHandlerInterface;
use App\Core\Domain\ExampleUser\Repository\ExampleUserRepositoryInterface;
use App\Core\Domain\ExampleUser\Specification\UniqueEmailSpecificationInterface;
use App\Core\Domain\ExampleUser\User;

class SignUpHandler implements CommandHandlerInterface
{
    public function __invoke(SignUpCommand $command): void
    {
        $user = User::create($command->uuid, $command->credentials, $this->uniqueEmailSpecification);

        $this->userRepository->store($user);
    }

    public function __construct(ExampleUserRepositoryInterface $userRepository, UniqueEmailSpecificationInterface $uniqueEmailSpecification)
    {
        $this->userRepository = $userRepository;
        $this->uniqueEmailSpecification = $uniqueEmailSpecification;
    }

    /**
     * @var ExampleUserRepositoryInterface
     */
    private $userRepository;

    /**
     * @var UniqueEmailSpecificationInterface
     */
    private $uniqueEmailSpecification;
}
