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

final class ProductAddedToStock implements Serializable
{
    public int $quantity;

    public function __construct(int $quantity)
    {
        $this->quantity = $quantity;
    }

    /**
     * {@inheritdoc}
     *
     * @throws AssertionFailedException
     */
    public static function deserialize(array $data)
    {
        Assertion::keyExists($data, 'quantity');

        return new self($data['quantity']);
    }

    /**
     * {@inheritdoc}
     */
    public function serialize(): array
    {
        return [
            'quantity' => $this->quantity,
        ];
    }
}
