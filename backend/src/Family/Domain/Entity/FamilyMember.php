<?php

declare(strict_types=1);

namespace App\Family\Domain\Entity;

use App\Family\Domain\ValueObject\FullName;
use App\Family\Domain\ValueObject\Gender;
use App\Family\Domain\ValueObject\LifePeriod;
use DateTimeImmutable;

final readonly class FamilyMember
{
    public function __construct(
        public int $id,
        public FullName $fullName,
        public Gender $gender,
        public LifePeriod $lifePeriod,
        public ?string $birthPlace,
        public ?string $deathPlace,
        public ?string $biography,
        public int $userId,
        public DateTimeImmutable $createdAt,
        public DateTimeImmutable $updatedAt
    ) {
    }
}
