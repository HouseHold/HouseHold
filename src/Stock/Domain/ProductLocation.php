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
use Doctrine\Common\Collections\ArrayCollection;
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
     *
     * @var string Please solve https://github.com/doctrine/common/issues/881 before adding strict type.
     */
    public $name;

    /**
     * @var ProductStock[]
     * @ORM\OneToMany(targetEntity="ProductStock", mappedBy="location")
     */
    public $stocks;

    public function __construct()
    {
        $this->products = new ArrayCollection();
    }

    public function getId(): string
    {
        return $this->id;
    }
}
