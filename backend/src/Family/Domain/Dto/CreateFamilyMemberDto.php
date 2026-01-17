<?php

declare(strict_types=1);

namespace App\Family\Application\Dto;

final readonly class CreateFamilyMemberDto
{
    public function __construct(
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
