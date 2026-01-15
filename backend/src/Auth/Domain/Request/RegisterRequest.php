<?php

declare(strict_types=1);

namespace App\Auth\Domain\Request;

final readonly class RegisterRequest
{
    public function __construct(
        public string $login,
        public string $password,
        public string $firstName,
        public ?string $middleName,
        public string $lastName,
        public string $email
    ) {
    }
}
