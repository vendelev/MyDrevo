<?php

declare(strict_types=1);

namespace App\Auth\Domain\Request;

final readonly class LoginRequest
{
    public function __construct(
        public string $email,
        public string $password,
        public bool $remember
    ) {
    }
}
