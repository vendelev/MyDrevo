<?php

declare(strict_types=1);

namespace Tests\Stub\ModelFactory;

use FamilyMember\Domain\Entity\FamilyMember;
use FamilyMember\Domain\ValueObject\FullName;
use FamilyMember\Domain\ValueObject\LifePeriod;

final class FamilyMemberFactory
{
    public static function create(): FamilyMember
    {
        return new FamilyMember(
            id: 1,
            fullName: new FullName('John Doe'),
            lifePeriod: new LifePeriod(
                birthDate: new \DateTimeImmutable('1990-01-01'),
                deathDate: null
            ),
            biography: 'Sample biography',
            photoUrl: null
        );
    }
}
