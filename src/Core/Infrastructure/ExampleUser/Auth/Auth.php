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

namespace App\Core\Infrastructure\ExampleUser\Auth;

use App\Core\Domain\ExampleUser\ValueObject\Auth\HashedPassword;
use App\Core\Domain\ExampleUser\ValueObject\Email;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Security\Core\Encoder\EncoderAwareInterface;
use Symfony\Component\Security\Core\ExampleUser\UserInterface;

class Auth implements UserInterface, EncoderAwareInterface
{
    /**
     * @throws \Assert\AssertionFailedException
     */
    public static function create(UuidInterface $uuid, string $email, string $hashedPassword): self
    {
        return new self($uuid, Email::fromString($email), HashedPassword::fromHash($hashedPassword));
    }

    public function getUsername(): string
    {
        return $this->email->toString();
    }

    public function getPassword(): string
    {
        return $this->hashedPassword->toString();
    }

    public function getRoles(): array
    {
        return [
            'ROLE_USER',
        ];
    }

    public function getSalt(): ?string
    {
        return null;
    }

    public function eraseCredentials(): void
    {
        // noop
    }

    public function getEncoderName(): string
    {
        return 'bcrypt';
    }

    public function uuid(): UuidInterface
    {
        return $this->uuid;
    }

    public function __toString(): string
    {
        return $this->email->toString();
    }

    private function __construct(UuidInterface $uuid, Email $email, HashedPassword $hashedPassword)
    {
        $this->uuid = $uuid;
        $this->email = $email;
        $this->hashedPassword = $hashedPassword;
    }

    /**
     * @var UuidInterface
     */
    private $uuid;

    /**
     * @var Email
     */
    private $email;

    /**
     * @var HashedPassword
     */
    private $hashedPassword;
}
