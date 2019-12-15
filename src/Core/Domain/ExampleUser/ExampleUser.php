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

namespace App\Core\Domain\ExampleUser;

use App\Core\Domain\ExampleUser\Event\UserEmailChanged;
use App\Core\Domain\ExampleUser\Event\UserSignedIn;
use App\Core\Domain\ExampleUser\Event\UserWasCreated;
use App\Core\Domain\ExampleUser\Exception\InvalidCredentialsException;
use App\Core\Domain\ExampleUser\Specification\UniqueEmailSpecificationInterface;
use App\Core\Domain\ExampleUser\ValueObject\Auth\Credentials;
use App\Core\Domain\ExampleUser\ValueObject\Auth\HashedPassword;
use App\Core\Domain\ExampleUser\ValueObject\Email;
use App\Core\Domain\Shared\ValueObject\DateTime;
use Assert\Assertion;
use Broadway\EventSourcing\EventSourcedAggregateRoot;
use Ramsey\Uuid\UuidInterface;

class ExampleUser extends EventSourcedAggregateRoot
{
    /**
     * @throws \App\Core\Domain\Shared\Exception\DateTimeException
     */
    public static function create(
        UuidInterface $uuid,
        Credentials $credentials,
        UniqueEmailSpecificationInterface $uniqueEmailSpecification
    ): self {
        $uniqueEmailSpecification->isUnique($credentials->email);

        $user = new self();

        $user->apply(new UserWasCreated($uuid, $credentials, DateTime::now()));

        return $user;
    }

    /**
     * @throws \App\Core\Domain\Shared\Exception\DateTimeException
     */
    public function changeEmail(
        Email $email,
        UniqueEmailSpecificationInterface $uniqueEmailSpecification
    ): void {
        $uniqueEmailSpecification->isUnique($email);
        $this->apply(new UserEmailChanged($this->uuid, $email, DateTime::now()));
    }

    /**
     * @throws InvalidCredentialsException
     */
    public function signIn(string $plainPassword): void
    {
        $match = $this->hashedPassword->match($plainPassword);

        if (!$match) {
            throw new InvalidCredentialsException('Invalid credentials entered.');
        }

        $this->apply(new UserSignedIn($this->uuid, $this->email));
    }

    protected function applyUserWasCreated(UserWasCreated $event): void
    {
        $this->uuid = $event->uuid;

        $this->setEmail($event->credentials->email);
        $this->setHashedPassword($event->credentials->password);
        $this->setCreatedAt($event->createdAt);
    }

    /**
     * @throws \Assert\AssertionFailedException
     */
    protected function applyUserEmailChanged(UserEmailChanged $event): void
    {
        Assertion::notEq($this->email->toString(), $event->email->toString(), 'New email should be different');

        $this->setEmail($event->email);
        $this->setUpdatedAt($event->updatedAt);
    }

    private function setEmail(Email $email): void
    {
        $this->email = $email;
    }

    private function setHashedPassword(HashedPassword $hashedPassword): void
    {
        $this->hashedPassword = $hashedPassword;
    }

    private function setCreatedAt(DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    private function setUpdatedAt(DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    public function createdAt(): string
    {
        return $this->createdAt->toString();
    }

    public function updatedAt(): ?string
    {
        return isset($this->updatedAt) ? $this->updatedAt->toString() : null;
    }

    public function email(): string
    {
        return $this->email->toString();
    }

    public function uuid(): string
    {
        return $this->uuid->toString();
    }

    public function getAggregateRootId(): string
    {
        return $this->uuid->toString();
    }

    /** @var UuidInterface */
    private $uuid;

    /** @var Email */
    private $email;

    /** @var HashedPassword */
    private $hashedPassword;

    /** @var DateTime */
    private $createdAt;

    /** @var DateTime|null */
    private $updatedAt;
}
