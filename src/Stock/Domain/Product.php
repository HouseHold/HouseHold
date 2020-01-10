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

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="stock_product")
 * @ApiResource()
 * @ApiFilter(SearchFilter::class, properties={"name": "start"})
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
     * @ORM\Column(type="string", unique=true)
     */
    public string $name;
    /**
     * @ORM\Column(type="json_array")
     */
    public array $ean;
    /**
     * @ORM\Column(type="float")
     */
    public float $price;
    /**
     * @ORM\Column(type="boolean")
     */
    public bool $expiring;
    /**
     * @ORM\Column(type="datetime")
     */
    public \DateTime $bestBefore;
    /**
     * @ORM\ManyToOne(targetEntity="ProductCollection", inversedBy="products")
     */
    public ProductCollection $collection;
    /**
     * @var ProductStock[]
     * @ORM\OneToMany(targetEntity="ProductStock", mappedBy="product")
     */
    public array $stocks;

    public function getId(): string
    {
        return $this->id;
    }
}
