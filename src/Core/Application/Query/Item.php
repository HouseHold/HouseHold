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

namespace App\Core\Application\Query;

use Broadway\ReadModel\SerializableReadModel;

final class Item
{
    /** @var string */
    public $id;

    /** @var string */
    public $type;

    /** @var array */
    public $resource;

    /** @var array */
    public $relationships = [];

    /** @var SerializableReadModel */
    public $readModel;

    public function __construct(SerializableReadModel $serializableReadModel, array $relations = [])
    {
        $this->id = $serializableReadModel->getId();
        $this->type = $this->type($serializableReadModel);
        $this->resource = $serializableReadModel->serialize();
        $this->relationships = $relations;
        $this->readModel = $serializableReadModel;
    }

    private function type(SerializableReadModel $model): string
    {
        $path = explode('\\', \get_class($model));

        return array_pop($path);
    }
}
