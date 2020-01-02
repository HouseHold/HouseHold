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

final class DrupalController extends AbstractController
{
    /**
     * @Feature(name="login")
     * @Feature(name="security")
     * @Feature(name="oauth")
     * @Feature(name="oauth_drupal")
     * @Route(name="connect_drupal_start", methods={"GET"}, path="/connect/drupal")
     */
    public function start(ClientRegistry $clientRegistry): Response
    {
        // Redirect to OAuth
        return $clientRegistry
            ->getClient('drupal')
            ->redirect($this->getConfig('security.authentication.drupal.scopes', []));
    }

    /**
     * @Feature(name="login")
     * @Feature(name="security")
     * @Feature(name="oauth")
     * @Feature(name="oauth_drupal")
     * @Route(name="connect_drupal_check", methods={"GET"}, path="/connect/drupal/callback")
     *
     * @see Drupal
     */
    public function check(): void
    {
        throw new NoGuardsLogicException('No guards defined for oauth_drupal!');
    }
}
