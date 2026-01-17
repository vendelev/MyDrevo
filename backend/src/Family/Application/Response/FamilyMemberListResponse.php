<?php

declare(strict_types=1);

namespace App\Family\Application\Response;

use App\Family\Application\Dto\FamilyMemberDto;

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
