<?php

declare(strict_types=1);

namespace Tests\Stub\ModelFactory;

use App\Example\Domain\Entity\Example;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Example>
 */
final class ExampleFactory extends Factory
{
    protected $model = Example::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'comment' => $this->faker->optional()->sentence(),
            'user_id' => $this->faker->numberBetween(1, 100),
            'created_at' => $this->faker->dateTime(),
        ];
    }
}
