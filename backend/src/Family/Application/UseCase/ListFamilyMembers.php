<?php

declare(strict_types=1);

namespace App\Family\Application\UseCase;

use App\Family\Application\Query\ListFamilyMembersQuery;
use App\Family\Domain\Entity\FamilyMember;

final readonly class ListFamilyMembers
{
    public function __construct(
        private ListFamilyMembersQuery $listFamilyMembersQuery,
    ) {
    }

    /**
     * @return FamilyMember[]
     */
    public function handle(int $userId): array
    {
        return $this->listFamilyMembersQuery->handle($userId);
    }
}
