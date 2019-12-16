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

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="stock_product")
 */
class Product
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
     * @ORM\Column(type="json_array")
     */
    public array $ean;
    /**
     * @ORM\Column(type="float")
     */
    public string $price;
    /**
     * @ORM\Column(type="boolean")
     */
    public bool $expiring;
    /**
     * @ORM\Column(type="datetime")
     */
    public \DateTime $bestBefore;
    /**
     * @ORM\OneToOne(targetEntity="App\Stock\Domain\ProductCollection", mappedBy="user", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    public ProductCollection $collection;

    public function getId(): string
    {
        return $this->id;
    }
}
