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

namespace App\Core\UI\Http\Rest\Controller\Healthz;

use App\Core\UI\Http\Rest\Controller\AbstractCommandQueryController;
use Swagger\Annotations as SWG;
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
     * @SWG\Response(
     *     response=200,
     *     description="OK"
     * )
     * @SWG\Response(
     *     response=500,
     *     description="Something not ok"
     * )
     *
     * @SWG\Tag(name="Healthz")
     */
    public function __invoke(): JsonResponse
    {
        return JsonResponse::create();
    }
}
