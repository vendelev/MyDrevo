<?php

declare(strict_types=1);

namespace App\Family\Application\Query;

use App\Family\Domain\Entity\FamilyMember;
use App\Family\Domain\FamilyMemberRepositoryInterface;

final readonly class ListFamilyMembersQuery
{
    public function __construct(
        private FamilyMemberRepositoryInterface $familyMemberRepository,
    ) {
    }

    /**
     * @return FamilyMember[]
     */
    public function handle(int $userId): array
    {
        return $this->familyMemberRepository->findAllByUserId($userId);
    }
}
