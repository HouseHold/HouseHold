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

use Assert\Assertion;
use Assert\AssertionFailedException;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\UuidInterface;

/**
 * @ORM\Entity()
 * @ORM\Cache(usage="READ_ONLY")
 */
abstract class AbstractEventStoreEntity
{
    /**
     * @ORM\Id
     * @ORM\Column(type="uuid_binary")
     */
    protected UuidInterface $id;
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", name="`index`")
     */
    protected int $index;
    /**
     * @ORM\Column(type="datetime_micro")
     */
    protected \DateTimeImmutable $recorded;
    /**
     * @ORM\Column(type="string")
     */
    protected string $type;
    /**
     * @ORM\Column(type="json")
     */
    protected array $payload;
    /**
     * @ORM\Column(type="json")
     */
    protected array $metadata;

    public function __construct(
        UuidInterface $id,
        int $playHead,
        \DateTimeImmutable $recorded,
        string $type,
        array $payload,
        array $metadata
    ) {
        $this->id = $id;
        $this->index = $playHead;
        $this->recorded = $recorded;
        $this->type = $type;
        $this->payload = $payload;
        $this->metadata = $metadata;
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getPlayHead(): int
    {
        return $this->index;
    }

    public function getRecorded(): \DateTimeImmutable
    {
        return $this->recorded;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getPayload(): array
    {
        return $this->payload;
    }

    public function getMetadata(): array
    {
        return $this->metadata;
    }

    public function toArray(): array
    {
        return [
            'id'          => $this->id,
            'playhead'    => $this->index,
            'recorded_on' => $this->recorded,
            'type'        => $this->type,
            'payload'     => $this->payload,
            'metadata'    => $this->metadata,
        ];
    }

    /**
     * @throws AssertionFailedException
     */
    public function fromArray(array $event): self
    {
        Assertion::keyExists($event, 'id');
        Assertion::keyExists($event, 'playhead');
        Assertion::keyExists($event, 'recorded_on');
        Assertion::keyExists($event, 'type');
        Assertion::keyExists($event, 'payload');
        Assertion::keyExists($event, 'metadata');

        return new static(
            $event['id'],
            $event['playhead'],
            $event['recorded_on'],
            $event['type'],
            $event['payload'],
            $event['metadata'],
        );
    }
}
