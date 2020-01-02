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

namespace App\Security\UI\Http\Web\Controller;

use App\Core\UI\Http\Web\Controller\AbstractController;
use Flagception\Bundle\FlagceptionBundle\Annotations\Feature;
use League\Tactician\CommandBus;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

final class LoginController extends AbstractController
{
    /**
     * @var CsrfTokenManagerInterface
     */
    private $csrfToken;

    public function __construct(CsrfTokenManagerInterface $csrfToken, CommandBus $commandBus, CommandBus $queryBus, RequestStack $requestStack)
    {
        $this->csrfToken = $csrfToken;
        parent::__construct($commandBus, $queryBus, $requestStack);
    }

    /**
     * @Feature(name="login")
     * @Feature(name="security")
     * @Route(methods={"GET"}, name="security_login", path="/login")
     */
    public function index(Request $request): Response
    {
        $params = ['csrf_token' => $this->csrfToken->getToken($request->getSession()->getId())];
        if ($this->getConfig('security.authentication.oauth.enabled', false)) {
            $default = $this->getConfig('security.authentication.oauth.default_provider');
            foreach ($this->getConfig('security.authentication.oauth.providers') as $provider => $desc) {
                // @noinspection PhpRouteMissingInspection
                $params['oauth_services'][$provider] =
                    [
                        'id'    => $provider,
                        'name'  => $desc,
                        'url'   => $this->generateUrl("connect_${provider}_start"),
                    ];
                if ($provider === $default) {
                    $params['oauth_services'][$provider]['default'] = true;
                }
            }
        }

        return $this->returnView($params);
    }
}
