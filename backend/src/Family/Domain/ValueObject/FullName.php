<?php

declare(strict_types=1);

namespace App\Modules\Family\Domain\ValueObject;

class FullName
{
    public function __construct(
        private readonly string $firstName,
        private readonly string $lastName,
        private readonly ?string $middleName = null
    ) {
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getMiddleName(): ?string
    {
        return $this->middleName;
    }

    public function getFullName(): string
    {
        $fullName = $this->firstName . ' ' . $this->lastName;
        if ($this->middleName) {
            $fullName .= ' ' . $this->middleName;
        }
        return $fullName;
    }
}