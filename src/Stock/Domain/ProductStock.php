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

/**
 * @ORM\Entity
 * @ORM\Table(name="stock_inventory")
 * @ApiResource
 */
class ProductStock
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     * @ORM\Column(type="string")
     */
    private string $id;

    /**
     * @var Product
     * @ORM\ManyToOne(targetEntity="Product", inversedBy="stocks")
     */
    public $product;

    /**
     * @var ProductLocation
     * @ORM\ManyToOne(targetEntity="ProductLocation", inversedBy="stocks")
     */
    public $location;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    public int $quantity = 0;

    public function getId(): string
    {
        return $this->id;
    }
}
