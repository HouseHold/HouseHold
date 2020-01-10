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

use Symfony\Component\DependencyInjection\ContainerInterface;

final class ContainerSingleton
{
    private static ContainerInterface $container;

    public static function register(ContainerInterface $container)
    {
        if (isset(static::$container)) {
            throw new \LogicException('Cannot set Container twice.');
        }

        static::$container = $container;
    }

    public static function get(): ContainerInterface
    {
        return self::$container;
    }
}
