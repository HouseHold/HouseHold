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
use Doctrine\ORM\PersistentCollection;
use Ramsey\Uuid\UuidInterface as Id;

/**
 * @ORM\Entity
 * @ORM\Table(name="stock_product")
 * @ORM\Cache(usage="READ_ONLY")
 * @ApiResource()
 * @ApiFilter(SearchFilter::class, properties={"name": "start"})
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
     * @ORM\Column(type="uuid_binary")
     */
    private Id $id;
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
     * @ORM\ManyToOne(targetEntity="ProductCollection", inversedBy="products")
     * @ORM\Cache
     */
    public ProductCollection $collection;
    /**
     * @var ProductStock[]|PersistentCollection
     * @ORM\OneToMany(targetEntity="ProductStock", mappedBy="product")
     * @ORM\Cache
     */
    public PersistentCollection $stocks;

    public function __construct(
        string $name,
        array $ean,
        float $price,
        bool $expiring,
        ProductCollection $collection
    ) {
        $this->name = $name;
        $this->ean = $ean;
        $this->price = $price;
        $this->expiring = $expiring;
        $this->collection = $collection;
    }

    public function getId(): Id
    {
        return $this->id;
    }
}
