<?php

declare(strict_types=1);

namespace Tests\Suite\Family\Domain;

use App\Family\Domain\Entity\Relationship;
use App\Family\Domain\ValueObject\RelationshipType;
use DateTimeImmutable;
use Tests\TestCase;

final class RelationshipTest extends TestCase
{
    public function testRelationshipCreation(): void
    {
        $createdAt = new DateTimeImmutable('2026-01-01 10:00:00');
        $updatedAt = new DateTimeImmutable('2026-01-01 10:00:00');

        $relationship = new Relationship(
            id: 1,
            personId: 1,
            relativeId: 2,
            type: RelationshipType::PARENT,
            metadata: null,
            createdAt: $createdAt,
            updatedAt: $updatedAt
        );

        self::assertEquals(1, $relationship->id);
        self::assertEquals(1, $relationship->personId);
        self::assertEquals(2, $relationship->relativeId);
        self::assertEquals(RelationshipType::PARENT, $relationship->type);
        self::assertNull($relationship->metadata);
        self::assertEquals($createdAt, $relationship->createdAt);
        self::assertEquals($updatedAt, $relationship->updatedAt);
    }

    public function testRelationshipCreationWithMetadata(): void
    {
        $createdAt = new DateTimeImmutable('2026-01-01 10:00:00');
        $updatedAt = new DateTimeImmutable('2026-01-01 10:00:00');

        $relationship = new Relationship(
            id: 1,
            personId: 1,
            relativeId: 2,
            type: RelationshipType::PARENT,
            metadata: '{"test": "value"}',
            createdAt: $createdAt,
            updatedAt: $updatedAt
        );

        self::assertEquals('{"test": "value"}', $relationship->metadata);
    }
}
