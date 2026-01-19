<?php

declare(strict_types=1);

namespace Tests\Suite\Example\Application;

use App\Example\Application\Factory\ExampleRequestFactory;
use App\Example\Domain\Dto\Status;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Validation\Factory as ValidationFactoryInterface;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

final class ExampleRequestFactoryTest extends TestCase
{
    /**
     * @throws ValidationException|BindingResolutionException
     */
    public function testCreateRequestSuccessful(): void
    {
        // Arrange
        $json = [
            'name' => 'Test Name',
            'comment' => 'Test Comment',
            'status' => 'active',
        ];
        $userId = 123;

        $validationFactory = $this->service(ValidationFactoryInterface::class);

        $factory = new ExampleRequestFactory($validationFactory);

        // Act
        $request = $factory->createRequest($json, $userId);

        // Assert
        self::assertEquals('Test Name', $request->name);
        self::assertEquals('Test Comment', $request->comment);
        self::assertEquals(Status::ACTIVE, $request->status);
        self::assertEquals($userId, $request->userId);
    }

    /**
     * @throws ValidationException|BindingResolutionException
     */
    public function testCreateRequestInvalid(): void
    {
        // Arrange
        $json = ['name' => '']; // Invalid
        $userId = 123;

        $validationFactory = $this->service(ValidationFactoryInterface::class);

        $factory = new ExampleRequestFactory($validationFactory);

        // Act & Assert
        $this->expectException(ValidationException::class);
        $factory->createRequest($json, $userId);
    }
}
