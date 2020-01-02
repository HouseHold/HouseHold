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

namespace App\Core\Application\Query\Auth\GetToken;

use App\Core\Domain\ExampleUser\ValueObject\Email;

class GetTokenQuery
{
    /**
     * @var Email
     */
    public $email;

    public function __construct(string $email)
    {
        $this->email = Email::fromString($email);
    }
}
