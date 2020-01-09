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

namespace App\Core\Infrastructure\Share\Event\Repository;

use App\Core\Infrastructure\Share\Doctrine\DateTimeMicrosecondsType;
use Broadway\Domain\DateTime;
use Broadway\Domain\DomainEventStream;
use Broadway\Domain\DomainMessage;
use Broadway\EventStore\Dbal\DBALEventStoreException;
use Broadway\EventStore\EventStore;
use Broadway\EventStore\EventStreamNotFoundException;
use Broadway\EventStore\EventVisitor;
use Broadway\EventStore\Exception\DuplicatePlayheadException;
use Broadway\EventStore\Exception\InvalidIdentifierException;
use Broadway\EventStore\Management\Criteria;
use Broadway\EventStore\Management\CriteriaNotSupportedException;
use Broadway\EventStore\Management\EventStoreManagement;
use Broadway\Serializer\Serializer;
use Broadway\UuidGenerator\Converter\BinaryUuidConverterInterface;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\Driver\ResultStatement;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Schema\Table;
use Doctrine\DBAL\Version;

class DBALEventStore implements EventStore, EventStoreManagement
{
    private Connection $connection;

    private Serializer $payloadSerializer;

    private Serializer $metadataSerializer;

    private $loadStatement;

    private bool $hasNativeJsonType;

    private string $tableName;

    private bool $useBinary;

    private BinaryUuidConverterInterface $binaryUuidConverter;

    public function __construct(
        Connection $connection,
        Serializer $payloadSerializer,
        Serializer $metadataSerializer,
        string $tableName,
        bool $useBinary,
        BinaryUuidConverterInterface $binaryUuidConverter = null
    ) {
        $this->connection = $connection;
        $this->payloadSerializer = $payloadSerializer;
        $this->metadataSerializer = $metadataSerializer;
        $this->tableName = $tableName;
        $this->useBinary = (bool) $useBinary;
        $this->binaryUuidConverter = $binaryUuidConverter;

        if ($this->useBinary && Version::compare('2.5.0') >= 0) {
            throw new \InvalidArgumentException('The Binary storage is only available with Doctrine DBAL >= 2.5.0');
        }

        if ($this->useBinary && null === $binaryUuidConverter) {
            throw new \LogicException('Binary UUID converter is required when using binary.');
        }

        $this->hasNativeJsonType = $this->connection->getDatabasePlatform()->hasNativeJsonType();
    }

    /**
     * {@inheritdoc}
     */
    public function load($id): DomainEventStream
    {
        $statement = $this->prepareLoadStatement();
        $statement->bindValue(1, $this->convertIdentifierToStorageValue($id));
        $statement->bindValue(2, 0);
        $statement->execute();

        $events = [];
        while ($row = $statement->fetch()) {
            $events[] = $this->deserializeEvent($row);
        }

        if (empty($events)) {
            throw new EventStreamNotFoundException(sprintf('EventStream not found for aggregate with id %s for table %s.', $id, $this->tableName));
        }

        return new DomainEventStream($events);
    }

    /**
     * {@inheritdoc}
     */
    public function loadFromPlayhead($id, int $playhead): DomainEventStream
    {
        $statement = $this->prepareLoadStatement();
        $statement->bindValue(1, $this->convertIdentifierToStorageValue($id));
        $statement->bindValue(2, $playhead);
        $statement->execute();

        $events = [];
        while ($row = $statement->fetch()) {
            $events[] = $this->deserializeEvent($row);
        }

        return new DomainEventStream($events);
    }

    /**
     * {@inheritdoc}
     */
    public function append($id, DomainEventStream $eventStream): void
    {
        // noop to ensure that an error will be thrown early if the ID
        // is not something that can be converted to a string. If we
        // let this move on without doing this DBAL will eventually
        // give us a hard time but the true reason for the problem
        // will be obfuscated.
        $id = (string) $id;

        $this->connection->beginTransaction();

        try {
            /** @var DomainMessage $domainMessage */
            foreach ($eventStream as $domainMessage) {
                $this->insertMessage($this->connection, $domainMessage);
            }

            $this->connection->commit();
        } catch (UniqueConstraintViolationException $exception) {
            $this->connection->rollBack();

            throw new DuplicatePlayheadException($eventStream, $exception);
        } catch (DBALException $exception) {
            $this->connection->rollBack();

            throw DBALEventStoreException::create($exception);
        }
    }

    private function insertMessage(Connection $connection, DomainMessage $domainMessage)
    {
        $data = [
            'uuid'        => $this->convertIdentifierToStorageValue((string) $domainMessage->getId()),
            'playhead'    => $domainMessage->getPlayhead(),
            'metadata'    => false //$this->hasNativeJsonType
                ? $this->metadataSerializer->serialize($domainMessage->getMetadata())
                : json_encode($this->metadataSerializer->serialize($domainMessage->getMetadata())),
            'payload'     => false //$this->hasNativeJsonType
                ? $this->payloadSerializer->serialize($domainMessage->getPayload())
                : json_encode($this->payloadSerializer->serialize($domainMessage->getPayload())),
            'recorded_on' => (new \DateTimeImmutable($domainMessage->getRecordedOn()->toString()))->format(DateTimeMicrosecondsType::FORMAT),
            'type'        => $domainMessage->getType(),
        ];

        $connection->insert($this->tableName, $data);
    }

    public function configureSchema(Schema $schema): ?Table
    {
        if ($schema->hasTable($this->tableName)) {
            return null;
        }

        return $this->configureTable($schema);
    }

    public function configureTable(Schema $schema): Table
    {
        $schema = $schema ?: new Schema();

        $uuidColumnDefinition = [
            'type'   => 'guid',
            'params' => [
                'length' => 36,
            ],
        ];

        if ($this->useBinary) {
            $uuidColumnDefinition['type'] = 'binary';
            $uuidColumnDefinition['params'] = [
                'length' => 16,
                'fixed'  => true,
            ];
        }

        $table = $schema->createTable($this->tableName);

        $table->addColumn('uuid', $uuidColumnDefinition['type'], $uuidColumnDefinition['params']);
        $table->addColumn('playhead', 'integer', ['unsigned' => true]);
        $table->addColumn('payload', /*$this->hasNativeJsonType*/false ? 'json' : 'text');
        $table->addColumn('metadata', /*$this->hasNativeJsonType*/ false ? 'json' : 'text');
        $table->addColumn('recorded_on', DateTimeMicrosecondsType::TYPENAME);
        $table->addColumn('type', 'string', ['length' => 255]);

        $table->setPrimaryKey(['uuid', 'playhead']);

        return $table;
    }

    private function prepareLoadStatement()
    {
        if (null === $this->loadStatement) {
            $query = 'SELECT uuid, playhead, metadata, payload, recorded_on
                FROM '.$this->tableName.'
                WHERE uuid = ?
                AND playhead >= ?
                ORDER BY playhead ASC';
            $this->loadStatement = $this->connection->prepare($query);
        }

        return $this->loadStatement;
    }

    private function deserializeEvent(array $row): DomainMessage
    {
        return new DomainMessage(
            $this->convertStorageValueToIdentifier($row['uuid']),
            (int) $row['playhead'],
            $this->metadataSerializer->deserialize(
                false//$this->hasNativeJsonType
                ? $row['metadata']
                : json_decode($row['metadata'], true)
            ),
            $this->payloadSerializer->deserialize(
                false//$this->hasNativeJsonType
                ? $row['payload']
                : json_decode($row['payload'], true)
            ),
            DateTime::fromString($row['recorded_on'])
        );
    }

    private function convertIdentifierToStorageValue(string $id): string
    {
        if ($this->useBinary) {
            try {
                return $this->binaryUuidConverter->fromString($id);
            } catch (\Exception $e) {
                throw new InvalidIdentifierException('Only valid UUIDs are allowed to by used with the binary storage mode.');
            }
        }

        return $id;
    }

    private function convertStorageValueToIdentifier(string $id): string
    {
        if ($this->useBinary) {
            try {
                return $this->binaryUuidConverter->fromBytes($id);
            } catch (\Exception $e) {
                throw new InvalidIdentifierException('Could not convert binary storage value to UUID.');
            }
        }

        return $id;
    }

    public function visitEvents(Criteria $criteria, EventVisitor $eventVisitor): void
    {
        $statement = $this->prepareVisitEventsStatement($criteria);
        $statement->execute();

        while ($row = $statement->fetch()) {
            $domainMessage = $this->deserializeEvent($row);

            $eventVisitor->doWithEvent($domainMessage);
        }
    }

    private function prepareVisitEventsStatement(Criteria $criteria): ResultStatement
    {
        [$where, $bindValues, $bindValueTypes] = $this->prepareVisitEventsStatementWhereAndBindValues($criteria);

        $query = sprintf(
            'SELECT uuid, playhead, metadata, payload, recorded_on FROM %s %s ORDER BY recorded_on ASC',
            $this->tableName,
            $where
        );

        return $this->connection->executeQuery($query, $bindValues, $bindValueTypes);
    }

    private function prepareVisitEventsStatementWhereAndBindValues(Criteria $criteria): array
    {
        if ($criteria->getAggregateRootTypes()) {
            throw new CriteriaNotSupportedException('DBAL implementation cannot support criteria based on aggregate root types.');
        }

        $bindValues = [];
        $bindValueTypes = [];

        $criteriaTypes = [];

        if ($criteria->getAggregateRootIds()) {
            $criteriaTypes[] = 'uuid IN (:uuids)';

            if ($this->useBinary) {
                $bindValues['uuids'] = [];
                foreach ($criteria->getAggregateRootIds() as $id) {
                    $bindValues['uuids'][] = $this->convertIdentifierToStorageValue($id);
                }
                $bindValueTypes['uuids'] = Connection::PARAM_STR_ARRAY;
            } else {
                $bindValues['uuids'] = $criteria->getAggregateRootIds();
                $bindValueTypes['uuids'] = Connection::PARAM_STR_ARRAY;
            }
        }

        if ($criteria->getEventTypes()) {
            $criteriaTypes[] = 'type IN (:types)';
            $bindValues['types'] = $criteria->getEventTypes();
            $bindValueTypes['types'] = Connection::PARAM_STR_ARRAY;
        }

        if (!$criteriaTypes) {
            return ['', [], []];
        }

        $where = 'WHERE '.implode(' AND ', $criteriaTypes);

        return [$where, $bindValues, $bindValueTypes];
    }
}
