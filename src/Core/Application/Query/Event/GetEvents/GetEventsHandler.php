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

namespace App\Core\Application\Query\Event\GetEvents;

use App\Core\Application\Query\Collection;
use App\Core\Application\Query\QueryHandlerInterface;
use App\Core\Domain\Shared\Event\EventRepositoryInterface;

class GetEventsHandler implements QueryHandlerInterface
{
    /**
     * @throws \App\Core\Domain\Shared\Query\Exception\NotFoundException
     */
    public function __invoke(GetEventsQuery $query): Collection
    {
        $result = $this->eventRepository->page($query->page, $query->limit);

        return new Collection($query->page, $query->limit, $result['total'], $result['data']);
    }

    public function __construct(EventRepositoryInterface $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }

    /**
     * @var EventRepositoryInterface
     */
    private $eventRepository;
}
