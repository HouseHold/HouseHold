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

/**
 * @ORM\Entity
 * @ORM\Table(name="stock_product_collection")
 * @ApiResource
 */
class ProductCollection
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

    public function getId(): string
    {
        return $this->id;
    }
}
