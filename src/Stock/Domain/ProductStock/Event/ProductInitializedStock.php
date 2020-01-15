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

namespace App\Stock\Domain\ProductStock\Event;

use Assert\Assertion;
use Assert\AssertionFailedException;
use Broadway\Serializer\Serializable;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface as Id;

final class ProductInitializedStock implements Serializable
{
    public Id $product;
    public Id $location;
    public Id $id;

    public function __construct(Id $id, Id $product, Id $location)
    {
        $this->product = $product;
        $this->location = $location;
        $this->id = $id;
    }

    /**
     * {@inheritdoc}
     *
     * @throws AssertionFailedException
     */
    public static function deserialize(array $data)
    {
        Assertion::keyExists($data, 'id');
        Assertion::keyExists($data, 'product');
        Assertion::keyExists($data, 'location');

        return new self(
            Uuid::fromString($data['id']),
            Uuid::fromString($data['product']),
            Uuid::fromString($data['location']),
        );
    }

    /**
     * {@inheritdoc}
     */
    public function serialize(): array
    {
        return [
            'id'       => $this->id->toString(),
            'location' => $this->location->toString(),
            'product'  => $this->product->toString(),
        ];
    }
}
