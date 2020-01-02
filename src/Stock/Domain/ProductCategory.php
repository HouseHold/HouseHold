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
 * @ORM\Table(name="stock_product_category")
 * @ApiResource
 */
class ProductCategory
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     * @ORM\Column(type="string")
     */
    private string $id;
    /**
     * @ORM\Column(type="string")
     *
     * @var string Please solve https://github.com/doctrine/common/issues/881 before adding strict type.
     */
    public $name;
    /**
     * @var ProductCollection[]|PersistentCollection
     * @ORM\OneToMany(targetEntity="ProductCollection", mappedBy="category", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    public $collections;

    public function getId(): string
    {
        return $this->id;
    }
}
