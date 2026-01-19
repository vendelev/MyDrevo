<?php

declare(strict_types=1);

namespace Tests\Suite\Example\Domain;

use App\Example\Domain\Exception\InvalidSubtractNumbersException;
use App\Example\Domain\ValueObject\SubtractNumbersVO;
use Tests\TestCase;

final class SubtractNumbersVOTest extends TestCase
{
    /**
     * @throws InvalidSubtractNumbersException
     */
    public function testConstructorWithDifferentNumbers(): void
    {
        // Arrange
        $number1 = 1.0;
        $number2 = 2.0;

        // Act
        $vo = new SubtractNumbersVO($number1, $number2);

        // Assert
        self::assertEquals($number1, $vo->number1);
        self::assertEquals($number2, $vo->number2);
    }

    /**
     * @throws InvalidSubtractNumbersException
     */
    public function testConstructorWithEqualNumbersThrowsException(): void
    {
        // Arrange
        $equalNumber = 1.0;

        // Act & Assert
        $this->expectException(InvalidSubtractNumbersException::class);
        $this->expectExceptionMessage('Cannot subtract equal numbers.');

        new SubtractNumbersVO($equalNumber, $equalNumber);
    }
}
