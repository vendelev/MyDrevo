<?php

declare(strict_types=1);

namespace Tests\Suite\Example\Domain;

use App\Example\Domain\Exception\InvalidSubtractNumbersException;
use Tests\TestCase;

final class InvalidSubtractNumbersExceptionTest extends TestCase
{
    public function testNumbersEqualFactoryMethod(): void
    {
        // Act
        $exception = InvalidSubtractNumbersException::numbersEqual();

        // Assert
        self::assertEquals('Cannot subtract equal numbers.', $exception->getMessage());
    }
}
