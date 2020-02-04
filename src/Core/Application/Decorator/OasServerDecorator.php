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

namespace App\Core\Application\Decorator;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

final class OasServerDecorator implements NormalizerInterface
{
    private NormalizerInterface $decorated;
    private RequestStack $requestStack;

    /**
     * SwaggerDecorator constructor.
     */
    public function __construct(NormalizerInterface $decorated, RequestStack $requestStack)
    {
        $this->decorated = $decorated;
        $this->requestStack = $requestStack;
    }

    /**
     * @param mixed  $object
     * @param string $format
     *
     * @throws \Symfony\Component\Serializer\Exception\ExceptionInterface
     *
     * @return array|string|int|float|bool|\ArrayObject|null
     */
    public function normalize($object, $format = null, array $context = [])
    {
        $docs = $this->decorated->normalize($object, $format, $context);
        $servers = [
            'servers' => [
                ['url' => '/', 'description' => 'As there is no SaaS, it\'s always relative to your URL.'],
            ],
        ];

        $docs = \array_slice($docs, 0, 2, true)
            + $servers
            + \array_slice($docs, 2, \count($docs) - 2, true);

        return $docs;
    }

    public function supportsNormalization($data, $format = null): bool
    {
        return $this->decorated->supportsNormalization($data, $format);
    }
}
