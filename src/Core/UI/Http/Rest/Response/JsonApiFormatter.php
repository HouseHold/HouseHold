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

namespace App\Core\UI\Http\Rest\Response;

use App\Core\Application\Query\Collection;
use App\Core\Application\Query\Item;

final class JsonApiFormatter
{
    public static function one(Item $resource): array
    {
        return array_filter([
            'data'          => self::model($resource),
            'relationships' => self::relations($resource->relationships),
        ]);
    }

    public static function collection(Collection $collection): array
    {
        $transformer = function ($data) {
            return $data instanceof Item ? self::model($data) : $data;
        };

        $resources = array_map($transformer, $collection->data);

        return array_filter([
            'meta' => [
                'size'  => $collection->limit,
                'page'  => $collection->page,
                'total' => $collection->total,
            ],
            'data' => $resources,
        ]);
    }

    private static function model(Item $resource): array
    {
        return [
            'id'         => $resource->id,
            'type'       => $resource->type,
            'attributes' => $resource->resource,
        ];
    }

    private static function relations(array $relations): array
    {
        $result = [];

        /** @var Item $relation */
        foreach ($relations as $relation) {
            $result[$relation->type] = [
                'data' => self::model($relation),
            ];
        }

        return $result;
    }
}
