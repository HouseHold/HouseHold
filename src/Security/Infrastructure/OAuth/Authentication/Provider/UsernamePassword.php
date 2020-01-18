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

namespace App\Security\Infrastructure\OAuth\Authentication\Provider;

use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Provider\ResourceOwnerInterface;
use League\OAuth2\Client\Token\AccessToken;
use Psr\Http\Message\ResponseInterface;

final class UsernamePassword extends AbstractProvider
{
    public function getAuthorizationUrl(array $options = []): string
    {
        return '/connect/username_password/login';
    }

    /**
     * Get provider url to run authorization.
     */
    public function getBaseAuthorizationUrl(): string
    {
        return '';
    }

    /**
     * Returns the base URL for requesting an access token.
     */
    public function getBaseAccessTokenUrl(array $params): string
    {
        return '';
    }

    /**
     * Get provider url to fetch user details.
     */
    public function getResourceOwnerDetailsUrl(AccessToken $token): string
    {
        return '';
    }

    /**
     * Get the default scopes used by this provider.
     */
    protected function getDefaultScopes(): array
    {
        return [];
    }

    /**
     * Check a provider response for errors.
     *
     * @param array|string $data
     */
    protected function checkResponse(ResponseInterface $response, $data): void
    {
        throw new \LogicException('Not implemented.');
    }

    /**
     * Generate a user object from a successful user details request.
     */
    protected function createResourceOwner(array $response, AccessToken $token): ResourceOwnerInterface
    {
        throw new \LogicException('Not implemented.');
    }
}
