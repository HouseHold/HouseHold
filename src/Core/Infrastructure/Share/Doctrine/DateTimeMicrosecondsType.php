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

namespace App\Core\Infrastructure\Share\Doctrine;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Platforms\MySqlPlatform;
use Doctrine\DBAL\Platforms\PostgreSqlPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\VarDateTimeImmutableType;

final class DateTimeMicrosecondsType extends VarDateTimeImmutableType
{
    public const FORMAT = 'Y-m-d H:i:s.u';
    public const TYPENAME = 'datetime_micro';

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        if (isset($fieldDeclaration['version']) && true === $fieldDeclaration['version']) {
            return 'TIMESTAMP';
        }
        if ($platform instanceof PostgreSqlPlatform) {
            return 'TIMESTAMP(6) WITHOUT TIME ZONE';
        }

        return 'DATETIME(6)';
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if (null === $value) {
            return $value;
        }

        if ($platform instanceof PostgreSqlPlatform || $platform instanceof MySqlPlatform) {
            if ($value instanceof \DateTimeInterface) {
                return $value->format('Y-m-d H:i:s.u');
            }
        }

        throw ConversionException::conversionFailedInvalidType($value, $this->getName(), ['null', 'DateTime']);
    }

    public function getName()
    {
        return self::TYPENAME;
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform)
    {
        return true;
    }
}
