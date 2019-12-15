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

namespace App\Security\Infrastructure\OAuth\Authentication\Provider;

use function base64_decode;
use function json_decode;
use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
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
     *
     * @throws IdentityProviderException
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
     *
     * @throws IdentityProviderException
     */
    protected function checkResponse(ResponseInterface $response, $data): void
    {
    }

    /**
     * Generate a user object from a successful user details request.
     *
     * @throws IdentityProviderException
     */
    protected function createResourceOwner(array $response, AccessToken $token): ResourceOwnerInterface
    {
        $payload = json_decode(base64_decode(explode('.', $token->getToken())[1], true), true, 512, JSON_THROW_ON_ERROR);
        $response['data']['session'] =
            [
                'expiry' => $payload['exp'],
                'roles'  => $payload['scopes'],
                'token'  => $token->getToken(),
                'refresh'=> $token->getRefreshToken(),
            ];

        $response['data']['profile'] = $this->fetchResourceOwnerDcDetails($token)['data'];

        return new \App\Security\Domain\OAuth\Resource\Drupal($response);
    }
}
