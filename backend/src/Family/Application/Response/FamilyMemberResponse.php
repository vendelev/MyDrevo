<?php

declare(strict_types=1);

namespace App\Family\Application\Response;

use App\Family\Application\Dto\FamilyMemberDto;

final readonly class FamilyMemberResponse
{
    public function __construct(
        public FamilyMemberDto $data,
    ) {
    }
}
