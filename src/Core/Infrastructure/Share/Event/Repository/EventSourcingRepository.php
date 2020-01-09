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

namespace App\Core\Infrastructure\Share\Event\Repository;

use App\Core\Infrastructure\Share\Event\Metadata\MetadataCollection;
use Broadway\EventHandling\EventBus;
use Broadway\EventSourcing\AggregateFactory\PublicConstructorAggregateFactory;
use Broadway\EventSourcing\MetadataEnrichment\MetadataEnrichingEventStreamDecorator;
use Broadway\EventStore\EventStore;

abstract class EventSourcingRepository extends \Broadway\EventSourcing\EventSourcingRepository
{
    public function __construct(EventStore $eventStore, EventBus $eventBus, string $aggregateClass, MetadataCollection $collection)
    {
        parent::__construct(
            $eventStore,
            $eventBus,
            $aggregateClass,
            new PublicConstructorAggregateFactory(),
            [new MetadataEnrichingEventStreamDecorator($collection->toArray())]
        );
    }
}
