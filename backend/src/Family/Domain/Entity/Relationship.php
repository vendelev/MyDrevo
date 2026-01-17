<?php

declare(strict_types=1);

namespace App\Family\Domain\Entity;

use App\Family\Domain\ValueObject\RelationshipType;
use DateTimeImmutable;

class Relationship
{
    public function __construct(
        public readonly int $id,
        public readonly int $personId,
        public readonly int $relativeId,
        public readonly RelationshipType $type,
        public readonly ?string $metadata,
        public readonly DateTimeImmutable $createdAt,
        public readonly DateTimeImmutable $updatedAt
    ) {
    }
}
