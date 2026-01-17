<?php

declare(strict_types=1);

namespace App\Family\Domain\Entity;

use App\Family\Domain\ValueObject\RelationshipType;
use DateTimeImmutable;

class Relationship
{
    public function __construct(
        private readonly int $id,
        private readonly int $personId,
        private readonly int $relativeId,
        private readonly RelationshipType $type,
        private readonly ?string $metadata,
        private readonly DateTimeImmutable $createdAt,
        private readonly DateTimeImmutable $updatedAt
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getPersonId(): int
    {
        return $this->personId;
    }

    public function getRelativeId(): int
    {
        return $this->relativeId;
    }

    public function getType(): RelationshipType
    {
        return $this->type;
    }

    public function getMetadata(): ?string
    {
        return $this->metadata;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
    }
}
