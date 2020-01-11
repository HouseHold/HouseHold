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
use Ramsey\Uuid\UuidInterface as Id;

/**
 * @ORM\Entity
 * @ORM\Table(name="stock_product_collection")
 * @ApiResource
 */
class ProductCollection
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\Column(type="uuid_binary")
     * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
     */
    private Id $id;
    /**
     * @ORM\Column(type="string")
     */
    public string $name;
    /**
     * @ORM\ManyToOne(targetEntity="ProductCategory", inversedBy="collections")
     * @ORM\JoinColumn(name="product_category_id", referencedColumnName="id")
     */
    public ProductCategory $category;
    /**
     * @var Product[]|PersistentCollection
     * @ORM\OneToMany(targetEntity="Product", mappedBy="collection")
     */
    public PersistentCollection $products;

    public function __construct(string $name, ProductCategory $category)
    {
        $this->name = $name;
        $this->category = $category;
    }

    public function getId(): Id
    {
        return $this->id;
    }
}
