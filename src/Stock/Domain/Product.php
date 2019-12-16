<?php

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

class Product
{
    private string $id;
    public string $name;
    public array $ean;
    public bool $expires;
    public \DateTime $bestBefore;
    public ProductCollection $collection;
}
