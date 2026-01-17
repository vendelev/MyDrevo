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

    public function updateFullName(FullName $fullName, DateTimeImmutable $updatedAt): self
    {
        return new self(
            id: $this->id,
            fullName: $fullName,
            gender: $this->gender,
            lifePeriod: $this->lifePeriod,
            birthPlace: $this->birthPlace,
            deathPlace: $this->deathPlace,
            biography: $this->biography,
            userId: $this->userId,
            createdAt: $this->createdAt,
            updatedAt: $updatedAt
        );
    }

    public function updateLifePeriod(LifePeriod $lifePeriod, DateTimeImmutable $updatedAt): self
    {
        return new self(
            id: $this->id,
            fullName: $this->fullName,
            gender: $this->gender,
            lifePeriod: $lifePeriod,
            birthPlace: $this->birthPlace,
            deathPlace: $this->deathPlace,
            biography: $this->biography,
            userId: $this->userId,
            createdAt: $this->createdAt,
            updatedAt: $updatedAt
        );
    }

    public function updateBiography(?string $biography, DateTimeImmutable $updatedAt): self
    {
        return new self(
            id: $this->id,
            fullName: $this->fullName,
            gender: $this->gender,
            lifePeriod: $this->lifePeriod,
            birthPlace: $this->birthPlace,
            deathPlace: $this->deathPlace,
            biography: $biography,
            userId: $this->userId,
            createdAt: $this->createdAt,
            updatedAt: $updatedAt
        );
    }
}
