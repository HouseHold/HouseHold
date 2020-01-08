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

namespace App\Core\Infrastructure\Share\Event\Metadata\Collection;

use App\Core\Infrastructure\Share\Event\Metadata\MetadataCollection;
use App\Core\Infrastructure\Share\Event\Metadata\UserMetadata;
use Broadway\EventSourcing\MetadataEnrichment\MetadataEnricher;

final class DefaultMetadataCollection implements MetadataCollection
{
    /**
     * @var MetadataEnricher[]
     */
    private array $arr = [];

    public function __construct(UserMetadata $userMetadata)
    {
        $this->arr[] = $userMetadata;
    }

    /**
     * {@inheritdoc}
     */
    public function toArray(): array
    {
        return $this->arr;
    }
}
