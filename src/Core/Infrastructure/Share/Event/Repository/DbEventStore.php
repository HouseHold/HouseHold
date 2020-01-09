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

use Broadway\Domain\DomainEventStream;
use Broadway\EventStore\EventStore;
use Broadway\EventStore\EventStreamNotFoundException;
use Broadway\EventStore\Exception\DuplicatePlayheadException;
use Ramsey\Uuid\UuidInterface;

/**
 * Interface DbEventStore.
 *
 * This is used for tagging EventStore implementations into container.
 */
interface DbEventStore extends EventStore
{
    /**
     * @param string|UuidInterface $id
     *
     * @throws EventStreamNotFoundException
     */
    public function load($id): DomainEventStream;

    /**
     * @param string $id
     */
    public function loadFromPlayhead($id, int $playhead): DomainEventStream;

    /**
     * @param string $id
     *
     * @throws DuplicatePlayheadException
     */
    public function append($id, DomainEventStream $eventStream): void;
}
