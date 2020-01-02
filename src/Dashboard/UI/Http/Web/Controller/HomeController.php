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

namespace App\Dashboard\UI\Http\Web\Controller;

use App\Core\UI\Http\Web\Controller\AbstractController;
use Flagception\Bundle\FlagceptionBundle\Annotations\Feature;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class HomeController extends AbstractController
{
    /**
     * @Feature(name="home")
     * @Feature(name="dashboard")
     * @Route(methods={"GET"}, name="home", path="/")
     */
    public function index(): Response
    {
        return $this->returnView();
    }
}
