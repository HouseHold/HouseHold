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

namespace App\Core\Infrastructure\Singletons;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;

final class EvenDispatcherSingleton
{
    private static EventDispatcherInterface $eventDispatcher;

    public static function register(EventDispatcherInterface $eventDispatcher)
    {
        if (isset(static::$eventDispatcher)) {
            throw new \LogicException('Cannot set EventDispatcher twice.');
        }

        static::$eventDispatcher = $eventDispatcher;
    }

    public static function get(): EventDispatcherInterface
    {
        return self::$eventDispatcher;
    }
}
