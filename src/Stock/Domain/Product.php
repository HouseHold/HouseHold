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

class Product
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */private string $id;
    /**
     * @ORM\Column(type="string")
     */
    public string $name;
    /**
     * @ORM\Column(type="string")
     */
    public array $ean;
    /**
     * @ORM\Column(type="string")
     */
    public bool $expires;
    /**
     * @ORM\Column(type="string")
     */
    public \DateTime $bestBefore;
    /**
     * @ORM\Column(type="string")
     */
    public ProductCollection $collection;
}
