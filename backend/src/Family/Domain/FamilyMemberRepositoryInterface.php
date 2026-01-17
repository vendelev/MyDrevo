<?php

declare(strict_types=1);

namespace App\Family\Domain;

use App\Family\Domain\Entity\FamilyMember;

interface FamilyMemberRepositoryInterface
{
    public function save(FamilyMember $familyMember): void;

    public function findById(int $id): ?FamilyMember;

    public function findByUserId(int $userId): ?FamilyMember;

    /**
     * @return FamilyMember[]
     */
    public function findAllByUserId(int $userId): array;

    public function delete(int $id): void;
}
