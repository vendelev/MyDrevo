<?php

declare(strict_types=1);

namespace Tests\Suite\Auth\E2E;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

final class WebAuthenticationFlowTest extends TestCase
{
    use WithFaker;

    public function testFullRegistrationCycleAndDashboardAccess(): void
    {
        // Check if route exists
        self::assertTrue(Route::has('register'));

        // Arrange
        $userData = [
            'login' => $this->faker->userName(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => 'password123',
            'first_name' => $this->faker->firstName(),
            'middle_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
        ];

        // Act: Submit registration form
        $response = $this->post('/register', $userData);

        // Assert: Redirect to dashboard
        $response->assertRedirect('/dashboard');

        // Act: Access dashboard
        $response = $this->get('/dashboard');

        // Assert: Status 200
        $response->assertStatus(200);
    }

    public function testDashboardProtectionForGuests(): void
    {
        // Act: Try to access dashboard without authentication
        $response = $this->get('/dashboard');

        // Assert: Redirect to login
        $response->assertRedirect('/login');
        $this->assertGuest();
    }
}
