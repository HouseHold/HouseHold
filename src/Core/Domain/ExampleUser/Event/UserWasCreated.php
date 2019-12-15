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

namespace App\Core\Domain\ExampleUser\Event;

use App\Core\Domain\ExampleUser\ValueObject\Auth\Credentials;
use App\Core\Domain\ExampleUser\ValueObject\Auth\HashedPassword;
use App\Core\Domain\ExampleUser\ValueObject\Email;
use App\Core\Domain\Shared\ValueObject\DateTime;
use Assert\Assertion;
use Broadway\Serializer\Serializable;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final class UserWasCreated implements Serializable
{
    /**
     * @throws \App\Core\Domain\Shared\Exception\DateTimeException
     * @throws \Assert\AssertionFailedException
     */
    public static function deserialize(array $data): self
    {
        Assertion::keyExists($data, 'uuid');
        Assertion::keyExists($data, 'credentials');

        return new self(
            Uuid::fromString($data['uuid']),
            new Credentials(
                Email::fromString($data['credentials']['email']),
                HashedPassword::fromHash($data['credentials']['password'])
            ),
            DateTime::fromString($data['created_at'])
        );
    }

    public function serialize(): array
    {
        return [
            'uuid'        => $this->uuid->toString(),
            'credentials' => [
                'email'    => $this->credentials->email->toString(),
                'password' => $this->credentials->password->toString(),
            ],
            'created_at' => $this->createdAt->toString(),
        ];
    }

    public function __construct(UuidInterface $uuid, Credentials $credentials, DateTime $createdAt)
    {
        $this->uuid = $uuid;
        $this->credentials = $credentials;
        $this->createdAt = $createdAt;
    }

    /**
     * @var UuidInterface
     */
    public $uuid;

    /**
     * @var Credentials
     */
    public $credentials;

    /**
     * @var DateTime
     */
    public $createdAt;
}
