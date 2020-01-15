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

namespace App\Core\Domain\Shared\ValueObject;

use App\Core\Domain\Shared\Exception\DateTimeException;

final class DateTime
{
    // ISO8601 with microseconds.
    public const FORMAT = 'Y-m-d\TH:i:s.uP';

    private \DateTimeImmutable $dateTime;

    public static function now(): self
    {
        return self::create();
    }

    /**
     * @throws DateTimeException
     */
    public static function fromString(string $dateTime): self
    {
        return self::create($dateTime);
    }

    /**
     * @throws DateTimeException
     */
    private static function create(string $dateTime = ''): self
    {
        $self = new self();

        try {
            $self->dateTime = new \DateTimeImmutable($dateTime);
        } catch (\Exception $e) {
            throw new DateTimeException($e);
        }

        return $self;
    }

    public function toString(string $format = ''): string
    {
        if ('' === $format) {
            $format = self::FORMAT;
        }

        return $this->dateTime->format($format);
    }

    public function toNative(): \DateTimeImmutable
    {
        return $this->dateTime;
    }

    public function __toString(): string
    {
        return $this->toString();
    }
}
