<?php

declare(strict_types=1);

namespace Tests\Stub\ModelFactory;

use FamilyMember\Domain\Entity\Relationship;

final class RelationshipFactory
{
    public static function create(): Relationship
    {
        return new Relationship(
            id: 1,
            personId: 1,
            relatedPersonId: 2,
            relationshipType: 'parent'
        );
    }
}