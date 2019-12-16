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

namespace App\Core\Infrastructure\Api;

use ApiPlatform\Core\Operation\PathSegmentNameGeneratorInterface;
use Doctrine\Common\Inflector\Inflector;

final class PathSegmentNameGeneratorSlash implements PathSegmentNameGeneratorInterface
{
    /**
     * {@inheritdoc}
     */
    public function getSegmentName(string $name, bool $collection = true): string
    {
        return $collection ? $this->slashize(Inflector::pluralize($name)) : $this->slashize($name);
    }

    private function slashize(string $string): string
    {
        return strtolower(preg_replace('~(?<=\\w)([A-Z])~', '/$1', $string));
    }
}
