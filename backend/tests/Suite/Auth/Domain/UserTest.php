<?php

declare(strict_types=1);

namespace Tests\Suite\Auth\Domain;

use App\Auth\Domain\Entity\User;
use Tests\TestCase;

final class UserTest extends TestCase
{
    public function testUserCreation(): void
    {
        $user = new User(
            id: 1,
            login: 'testuser',
            password: 'password',
            firstName: 'John',
            middleName: 'Doe',
            lastName: 'Smith',
            email: 'john@example.com',
            userType: 1,
            active: true,
            createdAt: new \DateTimeImmutable()
        );

        self::assertEquals(1, $user->getId());
        self::assertEquals('testuser', $user->getLogin());
        self::assertEquals('password', $user->getAuthPassword());
        self::assertEquals('John', $user->getFirstName());
        self::assertEquals('Doe', $user->getMiddleName());
        self::assertEquals('Smith', $user->getLastName());
        self::assertEquals('john@example.com', $user->getEmail());
        self::assertEquals(1, $user->getUserType());
        self::assertTrue($user->isActive());
    }
}
