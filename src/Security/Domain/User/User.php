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

namespace App\Security\Domain\User;

use App\Security\Domain\Profile\Profile;
use DH\DoctrineAuditBundle\Annotation\Auditable;
use DH\DoctrineAuditBundle\Annotation\Ignore;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="security_users")
 * @Auditable()
 */
class User implements UserInterface
{
    public const ADMIN_ID = 1;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     * @Ignore()
     */
    private int $id;

    /**
     * @ORM\Column(type="string")
     */
    public string $username;

    /**
     * @ORM\Column(type="string")
     */
    public string $email;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    public ?string $password;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    public ?string $salt;

    /**
     * @var array
     * @ORM\Column(type="json")
     */
    public array $roles;

    /**
     * @var Profile
     * @ORM\OneToOne(targetEntity="App\Security\Domain\Profile\Profile", mappedBy="user", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    public Profile $profile;

    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string The encoded password if any
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return string|null The salt
     */
    public function getSalt(): ?string
    {
        return $this->salt;
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials(): void
    {
    }

    /**
     * @return string[]
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    /**
     * Returns the username used to authenticate the user.
     *
     * @return string The username
     */
    public function getUsername(): string
    {
        return $this->username;
    }
}
