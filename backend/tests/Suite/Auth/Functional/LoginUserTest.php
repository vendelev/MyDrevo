<?php

declare(strict_types=1);

namespace Tests\Suite\Auth\Functional;

use App\Auth\Application\UseCase\LoginUser;
use App\Auth\Application\UseCase\RegisterUser;
use App\Auth\Domain\Request\LoginRequest;
use App\Auth\Domain\Request\RegisterRequest;
use Tests\TestCase;

final class LoginUserTest extends TestCase
{
    /**
     * @throws \DateMalformedStringException
     */
    public function testSuccessfulLogin(): void
    {
        // Arrange: Create a user first
        $registerRequest = new RegisterRequest(
            login: 'testuser',
            password: 'password123',
            firstName: 'John',
            middleName: 'Doe',
            lastName: 'Smith',
            email: 'john@example.com'
        );

        $registerUser = $this->service(RegisterUser::class);
        $registeredUser = $registerUser->handle($registerRequest);

        $loginRequest = new LoginRequest(
            email: 'john@example.com',
            password: 'password123',
            remember: false
        );

        $loginUser = $this->service(LoginUser::class);

        // Act
        $user = $loginUser->handle($loginRequest);

        // Assert
        self::assertEquals($registeredUser->getId(), $user->getId());
        self::assertEquals('john@example.com', $user->getEmail());
    }

    /**
     * @throws \DateMalformedStringException
     */
    public function testLoginWithInvalidPasswordThrowsException(): void
    {
        // Arrange: Create a user first
        $registerRequest = new RegisterRequest(
            login: 'testuser',
            password: 'password123',
            firstName: 'John',
            middleName: 'Doe',
            lastName: 'Smith',
            email: 'john@example.com'
        );

        $registerUser = $this->service(RegisterUser::class);
        $registerUser->handle($registerRequest);

        $loginRequest = new LoginRequest(
            email: 'john@example.com',
            password: 'wrongpassword',
            remember: false
        );

        $loginUser = $this->service(LoginUser::class);

        // Act & Assert
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Invalid credentials');

        $loginUser->handle($loginRequest);
    }
}
