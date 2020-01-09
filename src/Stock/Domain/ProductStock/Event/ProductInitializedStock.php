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

use App\Stock\Domain\Product;
use App\Stock\Domain\ProductLocation;
use Assert\Assertion;
use Assert\AssertionFailedException;
use Broadway\Serializer\Serializable;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final class ProductInitializedStock implements Serializable
{
    public Product $product;

    /**
     * @var ProductLocation
     */
    public ProductLocation $location;

    public int $quantity;

    public UuidInterface $id;

    /**
     * ProductAddedToStock constructor.
     */
    public function __construct(UuidInterface $id, Product $product, ProductLocation $location, int $quantity)
    {
        $this->product = $product;
        $this->location = $location;
        $this->quantity = $quantity;
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
        Assertion::keyExists($data, 'quantity');

        return new self(
            Uuid::fromString($data['id']),
            unserialize($data['product'], ['allowed_classes' => [Product::class]]),
            unserialize($data['location'], ['allowed_classes' => [ProductLocation::class]]),
            $data['quantity']
        );
    }

    /**
     * {@inheritdoc}
     */
    public function serialize(): array
    {
        return [
            'id'       => $this->id->toString(),
            'location' => serialize($this->location),
            'product'  => serialize($this->product),
            'quantity' => $this->quantity,
        ];
    }
}
