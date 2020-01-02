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

namespace App\Security\Domain\OAuth;

use League\OAuth2\Client\Provider\ResourceOwnerInterface;

interface ResourceInterface extends ResourceOwnerInterface
{
    public function getLanguageCode(string $default = 'en'): string;

    public function getLoginDatetime(): \DateTimeImmutable;

    /**
     * @return string
     */
    public function getTimezone(): \DateTimeZone;

    public function getName(): string;

    public function getEmail(): string;

    public function getProviderName(): string;

    public function getFirstname(): string;

    public function getLastname(): string;

    public function getAddress(): string;

    public function getCity(): string;

    public function getZip(): string;

    public function getPhone(): string;
}
