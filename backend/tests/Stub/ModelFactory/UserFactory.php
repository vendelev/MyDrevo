<?php

declare(strict_types=1);

namespace Tests\Stub\ModelFactory;

use App\Auth\Domain\Entity\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<User>
 */
final class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        return [
            'login' => $this->faker->userName(),
            'password' => bcrypt('password123'),
            'fname' => $this->faker->firstName(),
            'sname' => $this->faker->optional()->firstName(),
            'surname' => $this->faker->lastName(),
            'email' => $this->faker->unique()->safeEmail(),
            'user_type' => 1,
            'active' => true,
            'create_date' => $this->faker->dateTime(),
        ];
    }
}
