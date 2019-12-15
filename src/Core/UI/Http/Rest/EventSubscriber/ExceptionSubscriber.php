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

namespace App\Core\UI\Http\Rest\EventSubscriber;

use App\Core\Domain\ExampleUser\Exception\ForbiddenException;
use App\Core\Domain\ExampleUser\Exception\InvalidCredentialsException;
use App\Core\Domain\Shared\Query\Exception\NotFoundException;
use Broadway\Repository\AggregateNotFoundException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\KernelEvents;

class ExceptionSubscriber implements EventSubscriberInterface
{
    public function onKernelException(GetResponseForExceptionEvent $event): void
    {
        /** @noinspection SubStrUsedAsStrPosInspection */
        $isApi = '/api/' === mb_substr($event->getRequest()->getRequestUri(), 0, 5);
        if (!$isApi || 'dev' === $this->environment) {
            return;
        }

        $exception = $event->getException();
        $response = new JsonResponse();
        $response->headers->set('Content-Type', 'application/vnd.api+json');
        $response->setStatusCode($this->getStatusCode($exception));
        $response->setData($this->getErrorMessage($exception, $response));

        $event->setResponse($response);
    }

    private function getStatusCode(\Exception $exception): int
    {
        return $this->determineStatusCode($exception);
    }

    private function getErrorMessage(\Exception $exception, Response $response): array
    {
        $error = [
            'errors'=> [
                'title'     => str_replace('\\', '.', \get_class($exception)),
                'detail'    => $this->getExceptionMessage($exception),
                'code'      => $exception->getCode(),
                'status'    => $response->getStatusCode(),
            ],
        ];

        if ('dev' === $this->environment) {
            $error = array_merge(
                $error,
                [
                    'meta' => [
                        'file'          => $exception->getFile(),
                        'line'          => $exception->getLine(),
                        'message'       => $exception->getMessage(),
                        'trace'         => $exception->getTrace(),
                        'traceString'   => $exception->getTraceAsString(),
                    ],
                ]
            );
        }

        return $error;
    }

    private function getExceptionMessage(\Exception $exception): string
    {
        return $exception->getMessage();
    }

    private function determineStatusCode(\Exception $exception): int
    {
        // Default status code is always 500
        $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR;

        switch (true) {
            case $exception instanceof HttpExceptionInterface:
                $statusCode = $exception->getStatusCode();

                break;
            case $exception instanceof InvalidCredentialsException:
                $statusCode = Response::HTTP_UNAUTHORIZED;

                break;
            case $exception instanceof ForbiddenException:
                $statusCode = Response::HTTP_FORBIDDEN;

                break;
            case $exception instanceof AggregateNotFoundException || $exception instanceof NotFoundException:
                $statusCode = Response::HTTP_NOT_FOUND;

                break;
            case $exception instanceof \InvalidArgumentException:
                $statusCode = Response::HTTP_BAD_REQUEST;

                break;
        }

        return $statusCode;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => 'onKernelException',
        ];
    }

    public function __construct()
    {
        $this->environment = getenv('APP_ENV') ?? 'dev';
    }

    /**
     * @var string
     */
    private $environment;
}
