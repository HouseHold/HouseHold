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

namespace App\Core\Infrastructure\ExampleUser\Auth\Guard;

use App\Core\Application\Command\ExampleUser\SignIn\SignInCommand;
use App\Core\Application\Query\ExampleUser\FindByEmail\FindByEmailQuery;
use App\Core\Application\Query\Item;
use App\Core\Domain\ExampleUser\Exception\InvalidCredentialsException;
use App\Core\Infrastructure\ExampleUser\Auth\Auth;
use App\Core\Infrastructure\ExampleUser\Query\Projections\UserView;
use League\Tactician\CommandBus;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;

final class LoginAuthenticator extends AbstractFormLoginAuthenticator
{
    private const LOGIN = 'login';

    private const SUCCESS_REDIRECT = 'profile';

    /**
     * Does the authenticator support the given Request?
     *
     * If this returns false, the authenticator will be skipped.
     */
    public function supports(Request $request): bool
    {
        return $request->getPathInfo() === $this->router->generate(self::LOGIN) && $request->isMethod('POST');
    }

    /**
     * Get the authentication credentials from the request and return them
     * as any type (e.g. an associate array).
     *
     * Whatever value you return here will be passed to getUser() and checkCredentials()
     *
     * For example, for a form login, you might:
     *
     *      return array(
     *          'username' => $request->request->get('_username'),
     *          'password' => $request->request->get('_password'),
     *      );
     *
     * Or for an API token that's on a header, you might use:
     *
     *      return array('api_key' => $request->headers->get('X-API-TOKEN'));
     *
     * @throws \UnexpectedValueException If null is returned
     *
     * @return mixed Any non-null value
     */
    public function getCredentials(Request $request)
    {
        return [
            'email'    => $request->request->get('_email'),
            'password' => $request->request->get('_password'),
        ];
    }

    /**
     * Return a UserInterface object based on the credentials.
     *
     * The *credentials* are the return value from getCredentials()
     *
     * You may throw an AuthenticationException if you wish. If you return
     * null, then a UsernameNotFoundException is thrown for you.
     *
     * @param mixed $credentials
     *
     * @throws AuthenticationException
     * @throws \Assert\AssertionFailedException
     */
    public function getUser($credentials, UserProviderInterface $userProvider): ?UserInterface
    {
        try {
            $email = $credentials['email'];
            $plainPassword = $credentials['password'];

            $query = new SignInCommand($email, $plainPassword);

            $this->bus->handle($query);

            /** @var Item $userItem */
            $userItem = $this->queryBus->handle(new FindByEmailQuery($email));
            /** @var UserView $user */
            $user = $userItem->readModel;

            return Auth::create($user->uuid(), $user->email(), $user->hashedPassword());
        } catch (InvalidCredentialsException $exception) {
            throw new AuthenticationException();
        }
    }

    /**
     * Returns true if the credentials are valid.
     *
     * If any value other than true is returned, authentication will
     * fail. You may also throw an AuthenticationException if you wish
     * to cause authentication to fail.
     *
     * The *credentials* are the return value from getCredentials()
     *
     * @param mixed $credentials
     *
     * @throws AuthenticationException
     */
    public function checkCredentials($credentials, UserInterface $user): bool
    {
        return true;
    }

    /**
     * Called when authentication executed and was successful!
     *
     * This should return the Response sent back to the user, like a
     * RedirectResponse to the last page they visited.
     *
     * If you return null, the current request will continue, and the user
     * will be authenticated. This makes sense, for example, with an API.
     *
     * @param string $providerKey The provider (i.e. firewall) key
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey): ?Response
    {
        return new RedirectResponse($this->router->generate(self::SUCCESS_REDIRECT));
    }

    protected function getLoginUrl(): string
    {
        return $this->router->generate(self::LOGIN);
    }

    public function __construct(CommandBus $commandBus, CommandBus $queryBus, UrlGeneratorInterface $router)
    {
        $this->bus = $commandBus;
        $this->router = $router;
        $this->queryBus = $queryBus;
    }

    /**
     * @var CommandBus
     */
    private $bus;

    /**
     * @var CommandBus
     */
    private $queryBus;

    /**
     * @var UrlGeneratorInterface
     */
    private $router;
}
