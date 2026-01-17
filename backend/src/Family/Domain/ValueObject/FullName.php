<?php

declare(strict_types=1);

namespace App\Family\Domain\ValueObject;

class FullName
{
    public function __construct(
        public readonly string $firstName,
        public readonly string $lastName,
        public readonly ?string $middleName = null
    ) {
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
