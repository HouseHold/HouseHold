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
 * @ORM\Table(name="stock_product_collection")
 * @ApiResource
 */
class ProductCollection
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     * @ORM\Column(type="string")
     */private string $id;
    /**
     * @ORM\Column(type="string")
     */
    public string $name;
    /**
     * @ORM\ManyToOne(targetEntity="ProductCategory", inversedBy="collections")
     * @ORM\JoinColumn(name="productCategory_id", referencedColumnName="id")
     */
    public ProductCategory $category;
    /**
     * @ORM\OneToOne(targetEntity="App\Stock\Domain\Product", inversedBy="collection")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     */
    public Product $product;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }
}
