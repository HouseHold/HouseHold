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

namespace App\Core\Infrastructure\Api\Filter;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use Doctrine\ORM\QueryBuilder;
use Ramsey\Uuid\Uuid;

final class BinaryUuidAwareSearchFilter extends SearchFilter
{
    protected function filterProperty(
        string $property,
        $value,
        QueryBuilder $queryBuilder,
        QueryNameGeneratorInterface $queryNameGenerator,
        string $resourceClass,
        string $operationName = null
    ) {
        if (
            1 === \count((array) $value)
            && ($this->properties[$property] ?? self::STRATEGY_EXACT) === self::STRATEGY_EXACT
            && Uuid::isValid($value)
        ) {
            $value = Uuid::fromString($value)->getBytes();
        }

        return parent::filterProperty($property, $value, $queryBuilder, $queryNameGenerator, $resourceClass, $operationName);
    }
}
