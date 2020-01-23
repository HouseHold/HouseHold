<?php


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
            \count((array)$value) === 1
            && ($this->properties[$property] ?? self::STRATEGY_EXACT) === self::STRATEGY_EXACT
            && Uuid::isValid($value)
        ) {
            $value = Uuid::fromString($value)->getBytes();
        }
        return parent::filterProperty($property, $value, $queryBuilder, $queryNameGenerator, $resourceClass, $operationName);
    }
}
