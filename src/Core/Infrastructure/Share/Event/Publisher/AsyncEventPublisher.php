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

namespace App\Core\Infrastructure\Share\Event\Publisher;

use Broadway\Domain\DomainMessage;
use Broadway\EventHandling\EventListener;
use Symfony\Component\Console\ConsoleEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;

final class AsyncEventPublisher implements EventPublisher, EventSubscriberInterface, EventListener
{
    public function publish(): void
    {
        if (empty($this->events)) {
            return;
        }

        foreach ($this->events as $event) {
            $this->eventProducer->publish(serialize($event), $event->getType());
        }
    }

    public function handle(DomainMessage $message): void
    {
        $this->events[] = $message;
    }

    public static function getSubscribedEvents()
    {
        return [];
        //return [
        //    KernelEvents::TERMINATE  => 'publish',
        //    ConsoleEvents::TERMINATE => 'publish',
        //];
    }

    public function __construct()
    {
        //$this->eventProducer = $eventProducer;
    }

    /**
     * @var ProducerInterface
     */
    private $eventProducer;

    /** @var DomainMessage[] */
    private $events = [];
}
