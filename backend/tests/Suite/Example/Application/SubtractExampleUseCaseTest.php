<?php

declare(strict_types=1);

namespace Tests\Suite\Example\Application;

use App\Example\Application\UseCase\SubtractExampleUseCase;
use App\Example\Domain\Exception\InvalidSubtractNumbersException;
use App\Example\Domain\ValueObject\SubtractNumbersVO;
use Tests\TestCase;

final class SubtractExampleUseCaseTest extends TestCase
{
    /**
     * @throws InvalidSubtractNumbersException
     */
    public function testSubtractAndMakeReport(): void
    {
        // Arrange
        $numbers = new SubtractNumbersVO(5.0, 3.0);
        $useCase = $this->service(SubtractExampleUseCase::class);

        // Act
        $result = $useCase->subtractAndMakeReport($numbers);

        // Assert
        self::assertStringContainsString('5', $result);
        self::assertStringContainsString('3', $result);
        self::assertStringContainsString('2', $result);
    }
}
