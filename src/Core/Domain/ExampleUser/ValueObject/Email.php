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

namespace App\Core\Domain\ExampleUser\ValueObject;

use Assert\Assertion;

class Email
{
    /**
     * @throws \Assert\AssertionFailedException
     */
    public static function fromString(string $email): self
    {
        Assertion::email($email, 'Not a valid email');

        $mail = new self();

        $mail->email = $email;

        return $mail;
    }

    public function toString(): string
    {
        return $this->email;
    }

    public function __toString(): string
    {
        return $this->email;
    }

    private function __construct()
    {
    }

    /** @var string */
    private $email;
}
