<?php

declare(strict_types=1);

namespace Tests\Suite\Family\Domain;

use App\Family\Domain\ValueObject\FullName;
use Tests\TestCase;

final class FullNameTest extends TestCase
{
    public function testFullNameCreation(): void
    {
        $fullName = new FullName('Иван', 'Иванов', 'Иванович');

        self::assertEquals('Иван', $fullName->firstName);
        self::assertEquals('Иванов', $fullName->lastName);
        self::assertEquals('Иванович', $fullName->middleName);
    }

    public function testFullNameCreationWithoutMiddleName(): void
    {
        $fullName = new FullName('Иван', 'Иванов');

        self::assertEquals('Иван', $fullName->firstName);
        self::assertEquals('Иванов', $fullName->lastName);
        self::assertNull($fullName->middleName);
    }

    public function testGetFullNameWithMiddleName(): void
    {
        $fullName = new FullName('Иван', 'Иванов', 'Иванович');

        self::assertEquals('Иван Иванов Иванович', $fullName->getFullName());
    }

    public function testGetFullNameWithoutMiddleName(): void
    {
        $fullName = new FullName('Иван', 'Иванов');

        self::assertEquals('Иван Иванов', $fullName->getFullName());
    }
}
