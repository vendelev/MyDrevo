<?php

declare(strict_types=1);

namespace Tests\Stub\ModelFactory;

use App\Example\Domain\Entity\ExampleOutbox;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ExampleOutbox>
 */
final class ExampleOutboxFactory extends Factory
{
    protected $model = ExampleOutbox::class;

    public function definition(): array
    {
        return [
            'serialized_data' => json_encode(['data' => $this->faker->sentence()]),
            'created' => $this->faker->date(),
            'updated' => $this->faker->date(),
        ];
    }
}
