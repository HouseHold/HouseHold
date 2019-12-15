<?php

declare(strict_types=1);

/**
 *
 * Household 2019 — NOTICE OF LICENSE
 * This source file is released under commercial license by copyright holders.
 *
 * @copyright 2017-2019 (c) Niko Granö (https://granö.fi)
 * @copyright 2014-2019 (c) IronLions (https://ironlions.fi)
 *
 */

namespace App\Core\Infrastructure\ExampleUser\Repository;

use App\Core\Domain\ExampleUser\ExampleUser;
use App\Core\Domain\ExampleUser\Repository\ExampleUserRepositoryInterface;
use Broadway\EventHandling\EventBus;
use Broadway\EventSourcing\AggregateFactory\PublicConstructorAggregateFactory;
use Broadway\EventSourcing\EventSourcingRepository;
use Broadway\EventStore\EventStore;
use Ramsey\Uuid\UuidInterface;

final class ExampleUserStore extends EventSourcingRepository implements ExampleUserRepositoryInterface
{
    public function store(ExampleUser $user): void
    {
        $this->save($user);
    }

    public function get(UuidInterface $uuid): ExampleUser
    {
        /** @var ExampleUser $user */
        $user = $this->load($uuid->toString());

        return $user;
    }

    public function __construct(
        EventStore $eventStore,
        EventBus $eventBus,
        array $eventStreamDecorators = []
    ) {
        parent::__construct(
            $eventStore,
            $eventBus,
            User::class,
            new PublicConstructorAggregateFactory(),
            $eventStreamDecorators
        );
    }
}
