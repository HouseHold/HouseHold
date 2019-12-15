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

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class JsonBodyParserSubscriber implements EventSubscriberInterface
{
    public function onKernelRequest(GetResponseEvent $event): void
    {
        $request = $event->getRequest();

        if (!$this->isJsonRequest($request)) {
            return;
        }

        $content = $request->getContent();

        if (empty($content)) {
            return;
        }

        if (!$this->transformJsonBody($request)) {
            $response = Response::create('Unable to parse json request.', Response::HTTP_BAD_REQUEST);
            $event->setResponse($response);
        }
    }

    private function isJsonRequest(Request $request): bool
    {
        return 'json' === $request->getContentType();
    }

    private function transformJsonBody(Request $request): bool
    {
        $data = json_decode((string) $request->getContent(), true);

        if (JSON_ERROR_NONE !== json_last_error()) {
            return false;
        }

        if (null === $data) {
            return true;
        }

        $request->request->replace($data);

        return true;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => 'onKernelRequest',
        ];
    }
}
