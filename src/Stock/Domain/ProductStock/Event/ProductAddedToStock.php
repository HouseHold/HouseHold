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

use App\Core\Domain\Shared\ValueObject\DateTime;
use Assert\Assertion;
use Assert\AssertionFailedException;
use Broadway\Serializer\Serializable;

final class ProductAddedToStock implements Serializable
{
    public int $quantity;
    public float $price;
    public ?DateTime $bestBefore;

    public function __construct(int $quantity, float $price, ?DateTime $bestBefore)
    {
        $this->quantity = $quantity;
        $this->bestBefore = $bestBefore;
        $this->price = $price;
    }

    /**
     * {@inheritdoc}
     *
     * @throws AssertionFailedException
     * @throws \App\Core\Domain\Shared\Exception\DateTimeException
     */
    public static function deserialize(array $data)
    {
        Assertion::keyExists($data, 'quantity');
        Assertion::keyExists($data, 'bestBefore');
        Assertion::keyExists($data, 'price');

        if (null !== $data['bestBefore']) {
            $data['bestBefore'] = DateTime::fromString($data['bestBefore']);
        }

        return new self($data['quantity'], $data['price'], $data['bestBefore']);
    }

    /**
     * {@inheritdoc}
     */
    public function serialize(): array
    {
        return [
            'quantity'   => $this->quantity,
            'price'      => $this->price,
            'bestBefore' => null === $this->bestBefore ? null : $this->bestBefore->toString(),
        ];
    }
}
