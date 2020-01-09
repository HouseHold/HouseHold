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

namespace App\Core\Infrastructure\Share\Event\Repository\DBAL;

use App\Core\Infrastructure\Share\Event\Repository\DbEventStore;
use Broadway\Serializer\SimpleInterfaceSerializer;
use Broadway\UuidGenerator\Converter\BinaryUuidConverter;
use Doctrine\DBAL\Connection;

abstract class AbstractDBALEventStore extends DBALEventStore implements DbEventStore
{
    protected string $table = '';

    public function __construct(
        Connection $connection
    ) {
        if ('' === $this->table) {
            throw new \LogicException('Property `table` must be specific for service '.static::class.'!');
        }

        parent::__construct(
            $connection,
            new SimpleInterfaceSerializer(),
            new SimpleInterfaceSerializer(),
            $this->table,
            true,
            new BinaryUuidConverter()
        );
    }

    public function getTable(): string
    {
        return $this->table;
    }
}
