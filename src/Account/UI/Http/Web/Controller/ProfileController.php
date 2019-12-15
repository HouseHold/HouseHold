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

namespace App\Account\UI\Http\Web\Controller;

use App\Core\UI\Http\Web\Controller\AbstractController;
use Flagception\Bundle\FlagceptionBundle\Annotations\Feature;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class ProfileController extends AbstractController
{
    /**
     * @Feature(name="profile")
     * @Feature(name="dashboard")
     * @Feature(name="account")
     * @Route(methods={"GET"}, name="profile", path="/profile")
     */
    public function index(Request $request): Response
    {
        if (null !== $request->get('id')) {
            return $this->redirectToRoute('profile');
        }

        return $this->returnView();
    }
}
