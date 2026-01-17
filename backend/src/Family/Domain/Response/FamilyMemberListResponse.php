<?php

declare(strict_types=1);

namespace App\Family\Domain\Response;

use App\Family\Domain\Dto\FamilyMemberDto;

final readonly class FamilyMemberListResponse
{
    /**
     * @param FamilyMemberDto[] $data
     */
    public function __construct(
        public array $data,
    ) {
    }
}
