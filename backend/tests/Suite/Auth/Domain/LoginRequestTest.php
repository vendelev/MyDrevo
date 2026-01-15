<?php

declare(strict_types=1);

namespace Tests\Suite\Auth\Domain;

use App\Auth\Domain\Request\LoginRequest;
use Tests\TestCase;

final class LoginRequestTest extends TestCase
{
    public function testLoginRequestCreation(): void
    {
        $request = new LoginRequest(
            email: 'john@example.com',
            password: 'password123',
            remember: true
        );

        self::assertEquals('john@example.com', $request->email);
        self::assertEquals('password123', $request->password);
        self::assertTrue($request->remember);
    }
}
