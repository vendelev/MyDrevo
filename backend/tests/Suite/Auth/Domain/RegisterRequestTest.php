<?php

declare(strict_types=1);

namespace Tests\Suite\Auth\Domain;

use App\Auth\Domain\Request\RegisterRequest;
use Tests\TestCase;

final class RegisterRequestTest extends TestCase
{
    public function testRegisterRequestCreation(): void
    {
        $request = new RegisterRequest(
            login: 'testuser',
            password: 'password123',
            firstName: 'John',
            middleName: 'Doe',
            lastName: 'Smith',
            email: 'john@example.com'
        );

        self::assertEquals('testuser', $request->login);
        self::assertEquals('password123', $request->password);
        self::assertEquals('John', $request->firstName);
        self::assertEquals('Doe', $request->middleName);
        self::assertEquals('Smith', $request->lastName);
        self::assertEquals('john@example.com', $request->email);
    }
}
