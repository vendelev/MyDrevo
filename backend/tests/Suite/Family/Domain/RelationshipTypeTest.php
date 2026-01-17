<?php

declare(strict_types=1);

namespace Tests\Suite\Family\Domain;

use App\Family\Domain\ValueObject\RelationshipType;
use Tests\TestCase;

final class RelationshipTypeTest extends TestCase
{
    public function testRelationshipTypeEnumValues(): void
    {
        self::assertEquals('parent', RelationshipType::PARENT->value);
        self::assertEquals('child', RelationshipType::CHILD->value);
        self::assertEquals('spouse', RelationshipType::SPOUSE->value);
        self::assertEquals('sibling', RelationshipType::SIBLING->value);
    }

    /**
     * @throws \TypeError
     * @throws \ValueError
     */
    public function testRelationshipTypeFromValue(): void
    {
        self::assertEquals(RelationshipType::PARENT, RelationshipType::from('parent'));
        self::assertEquals(RelationshipType::CHILD, RelationshipType::from('child'));
        self::assertEquals(RelationshipType::SPOUSE, RelationshipType::from('spouse'));
        self::assertEquals(RelationshipType::SIBLING, RelationshipType::from('sibling'));
    }
}
