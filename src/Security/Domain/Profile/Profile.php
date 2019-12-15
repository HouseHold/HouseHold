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

namespace App\Security\Domain\Profile;

use App\Security\Domain\User\User;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="users_profile")
 */
class Profile
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     * @ORM\Column(type="string")
     */
    private $id;

    /**
     * @var \DateTimeImmutable
     * @ORM\Column(type="datetime_immutable")
     */
    private $changed;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $address;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $zip;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $city;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $firstname;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $lastname;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $phone;

    /**
     * @var User
     * @ORM\OneToOne(targetEntity="App\Security\Domain\User\User", inversedBy="profile")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    public function getId(): string
    {
        return $this->id;
    }

    public function getChanged(): \DateTimeImmutable
    {
        return $this->changed;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function getZip(): string
    {
        return $this->zip;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getFirstname(): string
    {
        return $this->firstname;
    }

    public function getLastname(): string
    {
        return $this->lastname;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function getUser(): User
    {
        return $this->user;
    }
}
