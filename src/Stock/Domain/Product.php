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
 * @ORM\Table(name="stock_product")
 * @ApiResource()
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     * @ORM\Column(type="string")
     */
    private string $id;
    /**
     * @var string
     * @ORM\Column(type="string")
     */
    public $name;
    /**
     * @var array
     * @ORM\Column(type="json_array")
     */
    public $ean;
    /**
     * @var float
     * @ORM\Column(type="float")
     */
    public $price;
    /**
     * @var bool
     * @ORM\Column(type="boolean")
     */
    public $expiring;
    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    public $bestBefore;
    /**
     * @var ProductCollection
     * @ORM\ManyToOne(targetEntity="ProductCollection", inversedBy="products")
     */
    public $collection;
    /**
     * @var ProductLocation
     * @ORM\ManyToOne(targetEntity="ProductLocation", inversedBy="products")
     * @ORM\JoinColumn(name="productLocation_id", referencedColumnName="id")
     */
    public $location;
    /**
     * @var ProductStock[]
     * @ORM\OneToMany(targetEntity="ProductStock", mappedBy="product")
     */
    public $stocks;

    public function getId(): string
    {
        return $this->id;
    }
}
