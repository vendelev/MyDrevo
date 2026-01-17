<?php

declare(strict_types=1);

namespace App\Family\Application\Command;

final readonly class UpdateFamilyMemberCommand
{
    public function __construct(
        public int $id,
        public string $firstName,
        public string $lastName,
        public ?string $middleName,
        public string $gender,
        public ?string $birthDate,
        public ?string $birthPlace,
        public ?string $deathDate,
        public ?string $deathPlace,
        public ?string $biography,
    ) {
    }
}
