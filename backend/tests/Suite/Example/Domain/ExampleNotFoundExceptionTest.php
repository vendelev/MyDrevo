<?php

declare(strict_types=1);

namespace Tests\Suite\Example\Domain;

use App\Example\Domain\Exception\ExampleNotFoundException;
use Tests\TestCase;

final class ExampleNotFoundExceptionTest extends TestCase
{
    public function testByIdFactoryMethod(): void
    {
        // Arrange
        $id = 123;

        // Act
        $exception = ExampleNotFoundException::byId($id);

        // Assert
        self::assertEquals('Example with id 123 not found.', $exception->getMessage());
    }
}
