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

namespace App\Security\Domain\Profile;

use App\Security\Domain\User\User;
use DH\DoctrineAuditBundle\Annotation\Auditable;
use DH\DoctrineAuditBundle\Annotation\Ignore;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="security_profile")
 * @Auditable()
 */
class Profile
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     * @Ignore()
     */
    private int $id;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    public string $firstname;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    public string $lastname;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    public string $address;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    public string $zip;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    public string $city;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    public ?string $state;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    public string $country;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    public string $phone;

    /**
     * @var User
     * @ORM\OneToOne(targetEntity="App\Security\Domain\User\User", inversedBy="profile")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * @Ignore()
     */
    public User $user;

    public function getId(): int
    {
        return $this->id;
    }
}
