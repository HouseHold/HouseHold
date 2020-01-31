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

namespace App\Core\UI\Http\Rest\Controller\Healthz;

use App\Core\UI\Http\Rest\Controller\AbstractCommandQueryController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

final class HealthzController extends AbstractCommandQueryController
{
    /**
     * @Route(
     *     "/healthz",
     *     name="healthz",
     *     methods={"GET"}
     * )
     */
    public function __invoke(): JsonResponse
    {
        return JsonResponse::create();
    }
}
