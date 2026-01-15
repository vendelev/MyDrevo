<?php

declare(strict_types=1);

namespace Tests\Suite\Auth\Presentation;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

final class RegisterControllerE2ETest extends TestCase
{
    use WithFaker;

    public function testRegisterWithValidData(): void
    {
        // Arrange
        $userData = [
            'login' => $this->faker->userName(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => 'password123',
            'first_name' => $this->faker->firstName(),
            'middle_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
        ];

        // Act
        $response = $this->post('/register', $userData);

        // Assert: Redirect to dashboard
        $response->assertRedirect('/dashboard');
        $this->assertAuthenticated();
    }

    public function testRegisterWithExistingEmail(): void
    {
        // Arrange: Register first user
        $userData1 = [
            'login' => $this->faker->userName(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => 'password123',
            'first_name' => $this->faker->firstName(),
            'middle_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
        ];

        $this->post('/register', $userData1);

        // Try to register with same email
        $userData2 = [
            'login' => $this->faker->userName(),
            'email' => $userData1['email'], // same email
            'password' => 'password456',
            'first_name' => $this->faker->firstName(),
            'middle_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
        ];

        // Act
        $response = $this->post('/register', $userData2);

        // Assert: Redirect back with error
        $response->assertRedirect('/');
        $response->assertSessionHasErrors(['email']);
    }

    public function testRegisterWithInvalidData(): void
    {
        // Arrange
        $userData = [
            'login' => '', // required
            'email' => 'invalid-email',
            'password' => '123', // too short
            'first_name' => '',
            'last_name' => '',
        ];

        // Act
        $response = $this->post('/register', $userData);

        // Assert: Redirect back with validation errors
        $response->assertRedirect('/');
        $response->assertSessionHasErrors(['login', 'email', 'password', 'first_name', 'last_name']);
    }
}
