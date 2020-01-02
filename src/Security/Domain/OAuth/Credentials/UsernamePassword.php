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

namespace App\Security\Domain\OAuth\Credentials;

use App\Security\Domain\Exception\OAuth\Credentials\InvalidCredentialsException;
use Symfony\Component\HttpFoundation\Request;

final class UsernamePassword
{
    /**
     * @var string
     */
    private string $username;
    /**
     * @var string
     */
    private string $password;

    public function __construct(string $username, string $password)
    {
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * @throws InvalidCredentialsException
     *
     * @return static
     */
    public static function fromRequest(Request $request): self
    {
        $user = $request->get('_username');
        $pass = $request->get('_password');

        if (null === $user || null === $pass) {
            throw new InvalidCredentialsException('Username or Password parameter missing.');
        }

        return new self($user, $pass);
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}
