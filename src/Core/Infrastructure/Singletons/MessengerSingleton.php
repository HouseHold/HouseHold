<?php


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
        if(isset(self::$commandBus, self::$queryBus)) {
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
