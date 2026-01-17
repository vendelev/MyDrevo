<?php

declare(strict_types=1);

namespace App\Family\Domain\Entity;

use App\Family\Domain\ValueObject\FullName;
use App\Family\Domain\ValueObject\Gender;
use App\Family\Domain\ValueObject\LifePeriod;
use DateTimeImmutable;

final class FamilyMember
{
    public function __construct(
        public readonly int $id,
        public FullName $fullName,
        public readonly Gender $gender,
        public LifePeriod $lifePeriod,
        public ?string $biography,
        public readonly int $userId,
        public readonly DateTimeImmutable $createdAt,
        public DateTimeImmutable $updatedAt
    ) {
    }

    public function updateFullName(FullName $fullName): void
    {
        $this->fullName = $fullName;
        $this->updatedAt = new DateTimeImmutable();
    }

    public function updateLifePeriod(LifePeriod $lifePeriod): void
    {
        $this->lifePeriod = $lifePeriod;
        $this->updatedAt = new DateTimeImmutable();
    }

    public function updateBiography(?string $biography): void
    {
        $this->biography = $biography;
        $this->updatedAt = new DateTimeImmutable();
    }
}
