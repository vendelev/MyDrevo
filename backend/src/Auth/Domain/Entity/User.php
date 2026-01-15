<?php

declare(strict_types=1);

namespace App\Auth\Domain\Entity;

use Illuminate\Foundation\Auth\User as Authenticatable;

final class User extends Authenticatable
{
    public function __construct(
        private readonly int $id = 0,
        private readonly string $login = '',
        private readonly string $password = '',
        private readonly string $firstName = '',
        private readonly ?string $middleName = null,
        private readonly string $lastName = '',
        private readonly string $email = '',
        private readonly int $userType = 1,
        private readonly bool $active = true,
        private readonly \DateTimeImmutable $createdAt = new \DateTimeImmutable()
    ) {
        parent::__construct();
    }

    // Required by Laravel's Authenticatable
    public function getAuthIdentifierName(): string
    {
        return 'id';
    }

    public function getAuthIdentifier(): mixed
    {
        return $this->id;
    }

    public function getAuthPassword(): string
    {
        return $this->password;
    }

    public function getRememberToken(): string
    {
        return '';
    }

    public function setRememberToken($value): void
    {
    }

    public function getRememberTokenName(): string
    {
        return '';
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getLogin(): string
    {
        return $this->login;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getMiddleName(): ?string
    {
        return $this->middleName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getUserType(): int
    {
        return $this->userType;
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }
}
