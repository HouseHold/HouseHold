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

namespace App\Stock\Domain\ProductLocation\Repository;

use App\Stock\Domain\ProductLocation;
use App\Stock\Domain\ProductLocation\Exception\ProductLocationNotFoundByNameException;

interface GetProductLocationByName
{
    /**
     * Return productLocation by name or throw exception.
     * ProductLocation name must be exact.
     *
     * @throws ProductLocationNotFoundByNameException
     */
    public function getProductLocationByName(string $name): ProductLocation;
}
