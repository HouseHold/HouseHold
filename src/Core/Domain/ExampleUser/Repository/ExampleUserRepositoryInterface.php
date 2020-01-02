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

namespace App\Core\Domain\ExampleUser\Repository;

use App\Core\Domain\ExampleUser\ExampleUser;
use Ramsey\Uuid\UuidInterface;

interface ExampleUserRepositoryInterface
{
    public function get(UuidInterface $uuid): ExampleUser;

    public function store(ExampleUser $user): void;
}
