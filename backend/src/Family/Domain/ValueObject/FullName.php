<?php

declare(strict_types=1);

namespace App\Family\Domain\ValueObject;

final readonly class FullName
{
    public function __construct(
        public string $firstName,
        public string $lastName,
        public ?string $middleName = null
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
