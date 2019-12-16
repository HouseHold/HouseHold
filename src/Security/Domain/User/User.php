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

namespace App\Security\Domain\User;

use App\Security\Domain\Profile\Profile;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="security_users")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $username;

    /**
     * @ORM\Column(type="string")
     */
    private $email;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $password;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $salt;

    /**
     * @var ArrayCollection
     * @ORM\Column(type="array")
     */
    private $roles;

    /**
     * @var Profile
     * @ORM\OneToOne(targetEntity="App\Security\Domain\Profile\Profile", mappedBy="user", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $profile;

    /**
     * User constructor.
     */
    public function __construct()
    {
        $this->roles = new ArrayCollection();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string The username
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @return string[] The user roles
     */
    public function getRoles(): array
    {
        if (false === $this->roles) {
            return [];
        }

        return $this->roles->toArray();
    }

    /**
     * @return string|null The encoded password if any
     */
    public function getPassword(): ?string
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
     * No Credentials are saved in current system.
     */
    public function eraseCredentials(): void
    {
        $this->password = null;
    }

    public function getProfile(): ?Profile
    {
        return $this->profile;
    }

    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    public function setPassword(?string $password, ?string $salt): void
    {
        $this->password = $password;
        $this->salt = $salt;
    }

    public function setRoles(ArrayCollection $roles): void
    {
        $this->roles = $roles;
    }
}
