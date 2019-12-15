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

namespace App\Core\Infrastructure\Share\Event\Consumer;

use App\Core\Infrastructure\Share\Event\Query\EventElasticRepository;
use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;

class SendEventsToElasticConsumer implements ConsumerInterface
{
    public function execute(AMQPMessage $msg): void
    {
        $this->eventElasticRepository->store(unserialize($msg->body));
    }

    public function __construct(EventElasticRepository $eventElasticRepository)
    {
        $this->eventElasticRepository = $eventElasticRepository;
    }

    /**
     * @var EventElasticRepository
     */
    private $eventElasticRepository;
}
