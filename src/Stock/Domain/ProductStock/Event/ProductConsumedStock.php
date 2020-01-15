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
use Broadway\Serializer\Serializable;

final class ProductConsumedStock implements Serializable
{
    public int $quantity;
    public ?DateTime $bestBefore;

    public function __construct(int $quantity, ?DateTime $bestBefore)
    {
        $this->quantity = $quantity;
        $this->bestBefore = $bestBefore;
    }

    /**
     * {@inheritdoc}
     *
     * @throws \Exception
     * @throws \Assert\AssertionFailedException
     */
    public static function deserialize(array $data): self
    {
        Assertion::keyExists($data, 'quantity');
        Assertion::keyExists($data, 'bestBefore');

        if (null === $data['bestBefore']) {
            return new self($data['quantity'], null);
        }

        return new self($data['quantity'], DateTime::fromString($data['bestBefore']));
    }

    /**
     * {@inheritdoc}
     */
    public function serialize(): array
    {
        return [
            'quantity'   => $this->quantity,
            'bestBefore' => null === $this->bestBefore ? null : $this->bestBefore->toString(),
        ];
    }
}
