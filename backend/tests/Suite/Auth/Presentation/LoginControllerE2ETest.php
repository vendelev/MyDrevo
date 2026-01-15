<?php

declare(strict_types=1);

namespace Tests\Suite\Auth\Presentation;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

final class LoginControllerE2ETest extends TestCase
{
    use WithFaker;

    public function testLoginWithValidCredentials(): void
    {
        // Arrange: Register a user first
        $userData = [
            'login' => $this->faker->userName(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => 'password123',
            'first_name' => $this->faker->firstName(),
            'middle_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
        ];

        $this->post('/register', $userData);

        // Act: Attempt login
        $loginData = [
            'email' => $userData['email'],
            'password' => $userData['password'],
        ];

        $response = $this->post('/login', $loginData);

        // Assert: Redirect to dashboard
        $response->assertRedirect('/dashboard');
        $this->assertAuthenticated();
    }

    public function testLoginWithInvalidCredentials(): void
    {
        // Arrange
        $loginData = [
            'email' => 'nonexistent@example.com',
            'password' => 'wrongpassword',
        ];

        // Act
        $response = $this->post('/login', $loginData);

        // Assert: Redirect back with error
        $response->assertRedirect('/');
        $this->assertGuest();
        $response->assertSessionHas('error');
    }

    public function testLoginWithInvalidData(): void
    {
        // Arrange
        $loginData = [
            'email' => 'invalid-email',
            'password' => '123', // too short
        ];

        // Act
        $response = $this->post('/login', $loginData);

        // Assert: Redirect back with validation errors
        $response->assertRedirect('/');
        $response->assertSessionHasErrors(['email', 'password']);
    }
}
