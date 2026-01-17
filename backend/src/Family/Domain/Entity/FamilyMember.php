<?php

declare(strict_types=1);

namespace App\Modules\Family\Domain\Entity;

use App\Modules\Family\Domain\ValueObject\FullName;
use App\Modules\Family\Domain\ValueObject\Gender;
use App\Modules\Family\Domain\ValueObject\LifePeriod;
use DateTimeImmutable;

class FamilyMember
{
    public function __construct(
        private readonly int $id,
        private FullName $fullName,
        private Gender $gender,
        private LifePeriod $lifePeriod,
        private ?string $biography,
        private readonly int $userId,
        private readonly DateTimeImmutable $createdAt,
        private DateTimeImmutable $updatedAt
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getFullName(): FullName
    {
        return $this->fullName;
    }

    public function getGender(): Gender
    {
        return $this->gender;
    }

    public function getLifePeriod(): LifePeriod
    {
        return $this->lifePeriod;
    }

    public function getBiography(): ?string
    {
        return $this->biography;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
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