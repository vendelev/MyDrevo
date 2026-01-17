<?php

declare(strict_types=1);

namespace App\Family\Domain\Entity;

use App\Family\Domain\ValueObject\RelationshipType;
use DateTimeImmutable;

final readonly class Relationship
{
    public function __construct(
        public int $id,
        public int $personId,
        public int $relativeId,
        public RelationshipType $type,
        public ?string $metadata,
        public DateTimeImmutable $createdAt,
        public DateTimeImmutable $updatedAt
    ) {
    }
}
