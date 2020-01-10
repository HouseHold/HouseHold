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

namespace App\Core\Infrastructure;

use App\Core\Infrastructure\Singletons\ContainerSingleton;
use App\Core\Infrastructure\Singletons\EvenDispatcherSingleton;
use Symfony\Component\Console\ConsoleEvents;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;

final class KernelEventSubscriber implements EventSubscriberInterface
{
    /**
     * @var ContainerInterface
     */
    private ContainerInterface $container;
    /**
     * @var EventDispatcherInterface
     */
    private EventDispatcherInterface $eventDispatcher;

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST  => ['registerSingleton', -1500],
            ConsoleEvents::COMMAND => ['registerSingleton', -1500],
        ];
    }

    public function __construct(ContainerInterface $container, EventDispatcherInterface $eventDispatcher)
    {
        $this->container = $container;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function registerSingleton($event): void
    {
        ContainerSingleton::register($this->container);
        EvenDispatcherSingleton::register($this->eventDispatcher);
    }
}
