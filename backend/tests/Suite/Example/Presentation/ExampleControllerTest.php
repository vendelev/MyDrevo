<?php

declare(strict_types=1);

namespace Tests\Suite\Example\Presentation;

use App\Auth\Domain\Entity\User;
use App\Example\Domain\Entity\Example;
use Tests\Stub\ModelFactory\ExampleFactory;
use Tests\Stub\ModelFactory\UserFactory;
use Tests\TestCase;

final class ExampleControllerTest extends TestCase
{
    public function testCreateSuccessful(): void
    {
        // Arrange
        /** @var User $user */
        $user = UserFactory::new()->create(['id' => 1]);
        $this->actingAs($user);

        $data = [
            'name' => 'Test Example',
            'comment' => 'Test Comment',
            'status' => 'active',
        ];

        // Act
        $response = $this->postJson('/api/examples', $data);

        // Assert
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'value'
                ]
            ]);

        $responseData = $response->json();
        $id = $responseData['data']['value'];

        // Verify database
        $this->assertDatabaseHas('examples', [
            'id' => $id,
            'name' => 'Test Example',
            'comment' => 'Test Comment',
            'user_id' => $user->getId(),
        ]);

        // Verify outbox
        $this->assertDatabaseHas('example_outbox', [
            'outbox_id' => $id,
        ]);
    }

    public function testCreateInvalid(): void
    {
        // Arrange
        /** @var User $user */
        $user = UserFactory::new()->create();
        $this->actingAs($user);

        $data = [
            'name' => '', // Invalid
            'status' => 'invalid',
        ];

        // Act
        $response = $this->postJson('/api/examples', $data);

        // Assert
        $response->assertStatus(422);
    }

    public function testShowFound(): void
    {
        // Arrange
        /** @var User $user */
        $user = UserFactory::new()->create();
        $this->actingAs($user);

        /** @var Example $example */
        $example = ExampleFactory::new()->create(['user_id' => $user->id]);

        // Act
        $response = $this->get("/examples/{$example->id}");

        // Assert
        $response->assertStatus(200);
        $response->assertViewHas('example');

        $exampleData = $response->viewData('example');
        self::assertEquals($example->name, $exampleData->name);
        self::assertEquals($example->comment, $exampleData->comment);
    }

    public function testShowNotFound(): void
    {
        // Arrange
        /** @var User $user */
        $user = UserFactory::new()->create();
        $this->actingAs($user);

        // Act
        $response = $this->get('/examples/999');

        // Assert
        $response->assertStatus(404);
    }
}
