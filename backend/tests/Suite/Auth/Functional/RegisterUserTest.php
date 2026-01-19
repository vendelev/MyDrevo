<?php

declare(strict_types=1);

namespace Tests\Suite\Auth\Functional;

use App\Auth\Application\Query\GetUserByEmailQuery;
use App\Auth\Application\UseCase\RegisterUser;
use App\Auth\Domain\Request\RegisterRequest;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

final class RegisterUserTest extends TestCase
{
    /**
     * @throws \DateMalformedStringException
     */
    public function testSuccessfulRegistration(): void
    {
        // Arrange
        $registerRequest = new RegisterRequest(
            login: 'testuser',
            password: 'password123',
            firstName: 'John',
            middleName: 'Doe',
            lastName: 'Smith',
            email: 'john@example.com'
        );

        $registerUser = $this->service(RegisterUser::class);

        // Act
        $user = $registerUser->handle($registerRequest);

        // Assert
        self::assertEquals('testuser', $user->getLogin());
        self::assertEquals('john@example.com', $user->getEmail());
        self::assertEquals('John', $user->getFname());
        self::assertEquals('Doe', $user->getSname());
        self::assertEquals('Smith', $user->getSurname());
        self::assertTrue($user->isActive());
        self::assertEquals(1, $user->getUserType());
        self::assertTrue(Hash::check('password123', $user->getAuthPassword()));

        // Verify user is saved in DB
        $savedUser = $this->service(GetUserByEmailQuery::class)->handle('john@example.com');
        self::assertNotNull($savedUser);
        self::assertEquals($user->getId(), $savedUser->getId());
    }

    /**
     * @throws \DateMalformedStringException
     */
    public function testRegistrationWithExistingEmailThrowsException(): void
    {
        // Arrange: Create existing user
        $existingRequest = new RegisterRequest(
            login: 'existinguser',
            password: 'password123',
            firstName: 'Jane',
            middleName: null,
            lastName: 'Doe',
            email: 'jane@example.com'
        );

        $registerUser = $this->service(RegisterUser::class);
        $registerUser->handle($existingRequest); // Create first user

        // Act & Assert: Try to register with same email
        $duplicateRequest = new RegisterRequest(
            login: 'anotheruser',
            password: 'password456',
            firstName: 'Jane',
            middleName: 'Smith',
            lastName: 'Doe',
            email: 'jane@example.com' // Same email
        );

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Email already exists');

        $registerUser->handle($duplicateRequest);
    }
}
