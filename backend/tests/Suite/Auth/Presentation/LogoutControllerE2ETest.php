<?php

declare(strict_types=1);

namespace Tests\Suite\Auth\Presentation;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

final class LogoutControllerE2ETest extends TestCase
{
    use WithFaker;

    public function testLogout(): void
    {
        // Arrange: Register and login a user
        $userData = [
            'login' => $this->faker->userName(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => 'password123',
            'first_name' => $this->faker->firstName(),
            'middle_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
        ];

        $this->post('/register', $userData);
        $this->assertAuthenticated();

        // Act: Logout
        $response = $this->post('/logout');

        // Assert: Redirect to login
        $response->assertRedirect('/login');
        $this->assertGuest();
    }
}
