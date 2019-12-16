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

namespace App\Stock\Domain;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="stock_location")
 * @ApiResource
 */
class ProductLocation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     * @ORM\Column(type="string")
     */
    private string $id;

    /**
     * @ORM\Column(type="string")
     */
    private string $name;

    /**
     * @var Product
     * @ORM\OneToMany(targetEntity="Product", mappedBy="location", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    public Product $products;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }
}
