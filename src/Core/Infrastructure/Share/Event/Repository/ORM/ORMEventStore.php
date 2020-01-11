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

namespace App\Core\Infrastructure\Share\Event\Repository\ORM;

use App\Core\Infrastructure\Share\Event\Repository\ORM\ORMEventStoreStaticHelpers as Helper;
use Broadway\Domain\DomainEventStream;
use Broadway\EventStore\EventStore;
use Broadway\EventStore\EventStreamNotFoundException as NotFound;
use Broadway\EventStore\EventVisitor;
use Broadway\EventStore\Management\Criteria;
use Broadway\EventStore\Management\EventStoreManagement;
use Doctrine\Common\Collections\Criteria as ORMCriteria;
use Doctrine\Common\Collections\Selectable;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;

class ORMEventStore implements EventStore, EventStoreManagement
{
    protected string $entityClass = AbstractEventStoreEntity::class;
    protected EntityManagerInterface $em;
    /**
     * @var ObjectRepository|Selectable
     */
    protected ObjectRepository $repo;

    public function __construct(EntityManagerInterface $em)
    {
        if (AbstractEventStoreEntity::class === $this->entityClass) {
            throw new \LogicException('A entityClass property must be set!');
        }

        $this->em = $em;
        $this->repo = $em->getRepository($this->entityClass);
    }

    /**
     * {@inheritdoc}
     */
    public function load($id): DomainEventStream
    {
        $id = Helper::convertIdToString($id);
        /** @var AbstractEventStoreEntity[] $events */
        $events = $this->repo->matching(
            (new ORMCriteria())
            ->where(ORMCriteria::expr()->eq('id', $id))
            ->orderBy(['index' => ORMCriteria::ASC])
        );

        if (empty($events)) {
            throw new NotFound("EventStream not found with id of $id for $this->entityClass.");
        }

        return new DomainEventStream(Helper::deSerializeEntities($events));
    }

    /**
     * {@inheritdoc}
     */
    public function loadFromPlayhead($id, int $playhead): DomainEventStream
    {
        /** @var AbstractEventStoreEntity[] $events */
        $events = $this->repo->matching(
            (new ORMCriteria())
            ->where(ORMCriteria::expr()->eq('id', Helper::convertIdToString($id)))
            ->andWhere(ORMCriteria::expr()->gt('index', $playhead))
            ->orderBy(['index' => ORMCriteria::ASC])
        );

        return new DomainEventStream(Helper::deSerializeEntities($events));
    }

    /**
     * {@inheritdoc}
     */
    public function append($id, DomainEventStream $eventStream): void
    {
        // Just so Exception gets triggered. Otherwise there is hell of debugging.
        $id = Helper::convertIdToString($id);
        $entities = Helper::serializeEntities($eventStream, $this->entityClass);

        // Stage new entities into ORM.
        foreach ($entities as &$entity) {
            $this->em->persist($entity);
        }

        // Persist.
        $this->em->flush();
    }

    public function visitEvents(Criteria $criteria, EventVisitor $eventVisitor): void
    {
        var_dump('Please implement this. I have no idea.');

        throw new \LogicException('Please implement this. I have no idea.');
    }
}
