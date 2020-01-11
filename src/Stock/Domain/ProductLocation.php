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

namespace App\Stock\Domain;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;
use Ramsey\Uuid\UuidInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="stock_location")
 * @ApiResource
 */
class ProductLocation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\Column(type="uuid_binary")
     * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
     */
    private UuidInterface $id;

    /**
     * @ORM\Column(type="string")
     */
    public string $name;

    /**
     * @var ProductStock[]|PersistentCollection
     * @ORM\OneToMany(targetEntity="ProductStock", mappedBy="location")
     */
    public PersistentCollection $stocks;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }
}
