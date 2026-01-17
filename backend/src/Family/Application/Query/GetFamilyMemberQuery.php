<?php

declare(strict_types=1);

namespace App\Family\Application\Query;

use App\Family\Domain\Entity\FamilyMember;
use App\Family\Domain\FamilyMemberRepositoryInterface;

final readonly class GetFamilyMemberQuery
{
    public function __construct(
        private FamilyMemberRepositoryInterface $familyMemberRepository,
    ) {
    }

    public function handle(int $id): ?FamilyMember
    {
        return $this->familyMemberRepository->findById($id);
    }
}
