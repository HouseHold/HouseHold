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

namespace App\Core\Infrastructure\Share\Event\Query;

use App\Core\Domain\Shared\Event\EventRepositoryInterface;
use App\Core\Infrastructure\Share\Query\Repository\ElasticRepository;
use Broadway\Domain\DomainMessage;

final class EventElasticRepository extends ElasticRepository implements EventRepositoryInterface
{
    private const INDEX = 'events';

    public function store(DomainMessage $message): void
    {
        $document = [
            'type'        => $message->getType(),
            'payload'     => $message->getPayload()->serialize(),
            'occurred_on' => $message->getRecordedOn()->toString(),
        ];

        $this->add($document);
    }

    public function __construct(array $elasticConfig)
    {
        parent::__construct($elasticConfig, self::INDEX);
    }
}
