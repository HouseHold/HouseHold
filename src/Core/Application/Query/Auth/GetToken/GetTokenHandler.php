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

namespace App\Core\Application\Query\Auth\GetToken;

use App\Core\Application\Query\QueryHandlerInterface;
use App\Core\Domain\ExampleUser\Repository\GetExampleUserCredentialsByEmailInterface;
use App\Core\Infrastructure\ExampleUser\Auth\AuthenticationProvider;

class GetTokenHandler implements QueryHandlerInterface
{
    /**
     * @throws \Assert\AssertionFailedException
     */
    public function __invoke(GetTokenQuery $query): string
    {
        [$uuid, $email, $hashedPassword] = $this->userCredentialsByEmail->getCredentialsByEmail($query->email);

        return $this->authenticationProvider->generateToken($uuid, $email, $hashedPassword);
    }

    public function __construct(
        GetExampleUserCredentialsByEmailInterface $userCredentialsByEmail,
        AuthenticationProvider $authenticationProvider
    ) {
        $this->authenticationProvider = $authenticationProvider;
        $this->userCredentialsByEmail = $userCredentialsByEmail;
    }

    /**
     * @var GetExampleUserCredentialsByEmailInterface
     */
    private $userCredentialsByEmail;

    /**
     * @var AuthenticationProvider
     */
    private $authenticationProvider;
}
