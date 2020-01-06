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

final class ProductAddedToStock implements Serializable
{
    /**
     * @var Product
     */
    public Product $product;
    /**
     * @var ProductLocation
     */
    public ProductLocation $location;
    /**
     * @var int
     */
    public int $amount;
    /**
     * @var string
     */
    public string $id;

    public function __construct(string $id, Product $product, ProductLocation $location, int $amount)
    {
        $this->product = $product;
        $this->location = $location;
        $this->amount = $amount;
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
        Assertion::keyExists($data, 'location');
        Assertion::keyExists($data, 'product');
        Assertion::keyExists($data, 'amount');

        return new self(
            $data['data'],
            $data['location'],
            $data['product'],
            $data['amount']
        );
    }

    /**
     * {@inheritdoc}
     */
    public function serialize(): array
    {
        return [
            'data'     => $this->location,
            'location' => $this->location,
            'product'  => $this->product,
            'amount'   => $this->amount,
        ];
    }
}
