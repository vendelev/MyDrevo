<?php

declare(strict_types=1);

namespace App\Family\Domain\Response;

use App\Family\Domain\Dto\FamilyMemberDto;

final readonly class FamilyMemberResponse
{
    public function __construct(
        public FamilyMemberDto $data,
    ) {
    }
}
