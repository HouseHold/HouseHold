<?php

/**
 *
 * Household 2019 — NOTICE OF LICENSE
 * This source file is released under commercial license by copyright holders.
 *
 * @copyright 2017-2019 (c) Niko Granö (https://granö.fi)
 * @copyright 2014-2019 (c) IronLions (https://ironlions.fi)
 *
 */

namespace App\Core\Domain\ExampleUser\Repository;

use App\Core\Domain\ExampleUser\ValueObject\Email;
use Ramsey\Uuid\UuidInterface;

interface CheckExampleUserByEmailInterface
{
    public function existsEmail(Email $email): ?UuidInterface;
}
