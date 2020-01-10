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

namespace App\Core\Infrastructure\Share\Event\Repository\ORM;

use App\Core\Domain\Shared\ValueObject\DateTime as DT;
use App\Core\Infrastructure\Share\Event\Repository\ORM\AbstractEventStoreEntity as Entity;
use Broadway\Domain\DateTime;
use Broadway\Domain\DomainEventStream;
use Broadway\Domain\DomainMessage;
use Broadway\Serializer\SimpleInterfaceSerializer;
use Ramsey\Uuid\Uuid;

final class ORMEventStoreStaticHelpers
{
    public static function convertIdToString($id): string
    {
        if (\is_object($id)) {
            if (method_exists($id, '__toString')) {
                return (string) $id;
            }
            if (method_exists($id, 'toString')) {
                return $id->toString();
            }
        } elseif (!\is_string($id)) {
            throw new \LogicException('Id must be string or implement method __toString.');
        }

        return $id;
    }

    /**
     * @param AbstractEventStoreEntity[] $events
     */
    public static function deSerializeEntities(object $events): array
    {
        $results = [];
        foreach ($events as $event) {
            if (!($event instanceof Entity)) {
                throw new \LogicException(sprintf('Only %s can be processed.', Entity::class));
            }
            // @noinspection PhpParamsInspection
            $results[] = new DomainMessage(
                $event->getId(),
                $event->getPlayHead(),
                self::deSerializeData($event->getMetadata()),
                self::deSerializeData($event->getPayload()),
                DateTime::fromString($event->getRecorded()->format(DT::FORMAT))
            );
        }

        return $results;
    }

    /**
     * @return Entity[]
     * @noinspection PhpDocMissingThrowsInspection
     */
    public static function serializeEntities(DomainEventStream $stream, string $class): array
    {
        $entities = [];

        /** @var DomainMessage $event */
        foreach ($stream as $event) {
            // @noinspection PhpUnhandledExceptionInspection
            $entities[] = new $class(
                Uuid::fromString($event->getId()),
                $event->getPlayhead(),
                new \DateTimeImmutable($event->getRecordedOn()->toString()),
                $event->getType(),
                self::serializeData($event->getPayload()),
                self::serializeData($event->getMetadata()),
            );
        }

        return $entities;
    }

    public static function serializeData($object): array
    {
        return (new SimpleInterfaceSerializer())->serialize($object);
    }

    public static function deSerializeData(array $data): object
    {
        return (new SimpleInterfaceSerializer())->deserialize($data);
    }
}
