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

namespace App\Core\UI\Http\Rest\Controller;

use App\Core\UI\Http\Rest\Response\JsonApiFormatter;
use League\Tactician\CommandBus;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

abstract class AbstractCommandQueryController extends AbstractQueryController
{
    protected function exec($command): void
    {
        $this->commandBus->handle($command);
    }

    public function __construct(CommandBus $commandBus, CommandBus $queryBus, JsonApiFormatter $formatter, UrlGeneratorInterface $router)
    {
        parent::__construct($queryBus, $formatter, $router);
        $this->commandBus = $commandBus;
    }

    /**
     * @var CommandBus
     */
    private $commandBus;
}
