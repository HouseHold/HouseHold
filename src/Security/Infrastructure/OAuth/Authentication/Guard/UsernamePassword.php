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

namespace App\Security\Infrastructure\OAuth\Authentication\Guard;

use App\Security\Domain\Exception\OAuth\Credentials\InvalidCredentialsException;
use App\Security\Domain\User\User;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use KnpU\OAuth2ClientBundle\Security\Authenticator\SocialAuthenticator;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

final class UsernamePassword extends SocialAuthenticator
{
    private RouterInterface $router;
    private EntityManager $em;
    private LoggerInterface $logger;
    private UserPasswordEncoderInterface $encoder;

    public function __construct(
        LoggerInterface $logger,
        RouterInterface $router,
        UserPasswordEncoderInterface $encoder,
        EntityManagerInterface $em
    ) {
        $this->router = $router;
        $this->em = $em;
        $this->logger = $logger;
        $this->encoder = $encoder;
    }

    /**
     * Returns a response that directs the user to authenticate.
     *
     * This is called when an anonymous request accesses a resource that
     * requires authentication. The job of this method is to return some
     * response that "helps" the user start into the authentication process.
     *
     * Examples:
     *
     * - For a form login, you might redirect to the login page
     *
     *     return new RedirectResponse('/login');
     *
     * - For an API token authentication system, you return a 401 response
     *
     *     return new Response('Auth header required', 401);
     *
     * @param Request                 $request       The request that resulted in an AuthenticationException
     * @param AuthenticationException $authException The exception that started the authentication process
     */
    public function start(Request $request, AuthenticationException $authException = null): Response
    {
        return new RedirectResponse($this->router->generate('security_login'));
    }

    /**
     * Does the authenticator support the given Request?
     *
     * If this returns false, the authenticator will be skipped.
     */
    public function supports(Request $request): bool
    {
        return 'connect_user_pass_check' === $request->attributes->get('_route');
    }

    /**
     * Get the authentication credentials from the request and return them
     * as any type (e.g. an associate array).
     *
     * Whatever value you return here will be passed to getUser() and checkCredentials()
     *
     * @return \App\Security\Domain\OAuth\Credentials\UsernamePassword|bool Any non-null value
     */
    public function getCredentials(Request $request)
    {
        try {
            return \App\Security\Domain\OAuth\Credentials\UsernamePassword::fromRequest($request);
        } catch (InvalidCredentialsException $e) {
            return false;
        }
    }

    /**
     * Returns true if the credentials are valid.
     *
     * If false is returned, authentication will fail. You may also throw
     * an AuthenticationException if you wish to cause authentication to fail.
     *
     * The *credentials* are the return value from getCredentials()
     *
     * @param \App\Security\Domain\OAuth\Credentials\UsernamePassword $credentials
     * @param UserInterface|User                                      $user
     */
    public function checkCredentials($credentials, UserInterface $user): bool
    {
        return $this->encoder->isPasswordValid($user, $credentials->getPassword());
    }

    /**
     * Return a UserInterface object based on the credentials.
     *
     * The *credentials* are the return value from getCredentials()
     *
     * You may throw an AuthenticationException if you wish. If you return
     * null, then a UsernameNotFoundException is thrown for you.
     *
     * @param \App\Security\Domain\OAuth\Credentials\UsernamePassword $credentials
     */
    public function getUser($credentials, UserProviderInterface $userProvider): ?User
    {
        if (false === $credentials) {
            $this->logger->debug('=!= Username or Password not set in the request. =!=');

            throw new AuthenticationException('Username or Password missing.');
        }

        /** @var User $user */
        $user = $this->em->getRepository(User::class)->findOneBy(['username' => $credentials->getUsername()]);

        if (null === $user) {
            $user = $this->em->getRepository(User::class)->findOneBy(['email' => $credentials->getUsername()]);
        }

        return $user;
    }

    /**
     * Called when authentication executed, but failed (e.g. wrong username password).
     *
     * This should return the Response sent back to the user, like a
     * RedirectResponse to the login page or a 403 response.
     *
     * If you return null, the request will continue, but the user will
     * not be authenticated. This is probably not what you want to do.
     */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        $message = strtr($exception->getMessageKey(), $exception->getMessageData());

        return new Response($message, Response::HTTP_FORBIDDEN);
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
        return new RedirectResponse($this->router->generate('home'));
    }
}
