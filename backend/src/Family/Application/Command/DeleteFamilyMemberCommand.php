<?php

declare(strict_types=1);

namespace App\Family\Application\Command;

final readonly class DeleteFamilyMemberCommand
{
    public function __construct(
        public int $id,
    ) {
    }
}
