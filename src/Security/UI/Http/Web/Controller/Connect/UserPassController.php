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

namespace App\Security\UI\Http\Web\Controller\Connect;

use App\Core\UI\Http\Web\Controller\AbstractController;
use Flagception\Bundle\FlagceptionBundle\Annotations\Feature;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class UserPassController extends AbstractController
{
    /**
     * @Feature(name="login")
     * @Feature(name="security")
     * @Feature(name="oauth")
     * @Feature(name="oauth_username_password")
     * @Route(name="connect_user_pass_start", methods={"GET"}, path="/connect/username_password")
     */
    public function start(ClientRegistry $clientRegistry): Response
    {
        // Redirect to OAuth
        return $clientRegistry
            ->getClient('username_password')
            ->redirect();
    }

    /**
     * @Feature(name="login")
     * @Feature(name="security")
     * @Feature(name="oauth")
     * @Feature(name="oauth_username_password")
     * @Route(name="connect_user_pass_check", methods={"POST"}, path="/connect/username_password/callback")
     */
    public function check(): void
    {
        throw new NoGuardsLogicException('No guards defined for oauth_username_password!');
    }

    /**
     * @Feature(name="login")
     * @Feature(name="security")
     * @Feature(name="oauth")
     * @Feature(name="oauth_username_password")
     * @Route(name="connect_user_pass_login", methods={"GET"}, path="/connect/username_password/login")
     *
     * @see Drupal
     */
    public function login(): Response
    {
        return $this->returnView();
    }
}
