<?php

declare(strict_types=1);

namespace App\Family\Application\UseCase;

use App\Family\Application\Query\GetFamilyMemberQuery;
use App\Family\Domain\Entity\FamilyMember;

final readonly class GetFamilyMember
{
    public function __construct(
        private GetFamilyMemberQuery $getFamilyMemberQuery,
    ) {
    }

    public function handle(int $id): ?FamilyMember
    {
        return $this->getFamilyMemberQuery->handle($id);
    }
}
