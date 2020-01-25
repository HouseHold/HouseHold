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

use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\StampInterface;

final class MessengerSingleton
{
    private static MessageBusInterface $commandBus;
    private static MessageBusInterface $queryBus;

    public static function register(MessageBusInterface $commandBus, MessageBusInterface $queryBus): void
    {
        if (isset(self::$commandBus, self::$queryBus)) {
            return;
        }

        self::$commandBus = $commandBus;
        self::$queryBus = $queryBus;
    }

    /**
     * Dispatches the given message.
     *
     * @param object|Envelope  $message The message or the message pre-wrapped in an envelope
     * @param StampInterface[] $stamps
     */
    public static function run($message, array $stamps = []): Envelope
    {
        return self::$commandBus->dispatch($message, $stamps);
    }

    /**
     * Dispatches the given message.
     *
     * @param object|Envelope  $message The message or the message pre-wrapped in an envelope
     * @param StampInterface[] $stamps
     */
    public static function ask($message, array $stamps = []): Envelope
    {
        return self::$queryBus->dispatch($message, $stamps);
    }
}
