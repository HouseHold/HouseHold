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

namespace App\Core\UI\Http\Rest\Controller;

use App\Core\Application\Query\Collection;
use App\Core\Application\Query\Item;
use App\Core\UI\Http\Rest\Response\JsonApiFormatter;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

abstract class AbstractQueryController
{
    private const CACHE_MAX_AGE = 31536000; // Year.
    private JsonApiFormatter $formatter;
    private MessageBusInterface  $queryBus;
    private UrlGeneratorInterface $router;

    public function __construct(MessageBusInterface $queryBus, JsonApiFormatter $formatter, UrlGeneratorInterface $router)
    {
        $this->queryBus = $queryBus;
        $this->formatter = $formatter;
        $this->router = $router;
    }

    protected function ask($query)
    {
        return $this->queryBus->dispatch($query);
    }

    protected function jsonCollection(Collection $collection, bool $isImmutable = false): JsonResponse
    {
        $response = JsonResponse::create($this->formatter::collection($collection));

        $this->decorateWithCache($response, $collection, $isImmutable);

        return $response;
    }

    protected function json(Item $resource): JsonResponse
    {
        return JsonResponse::create($this->formatter->one($resource));
    }

    protected function route(string $name, array $params = []): string
    {
        return $this->router->generate($name, $params);
    }

    private function decorateWithCache(JsonResponse $response, Collection $collection, bool $isImmutable): void
    {
        if ($isImmutable && $collection->limit === \count($collection->data)) {
            $response
                ->setMaxAge(self::CACHE_MAX_AGE)
                ->setSharedMaxAge(self::CACHE_MAX_AGE);
        }
    }
}
