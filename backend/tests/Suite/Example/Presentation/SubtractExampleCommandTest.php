<?php

declare(strict_types=1);

namespace Tests\Suite\Example\Presentation;

use App\Example\Domain\Exception\InvalidSubtractNumbersException;
use Illuminate\Testing\PendingCommand;
use Tests\TestCase;

final class SubtractExampleCommandTest extends TestCase
{
    public function testSuccessfulSubtraction(): void
    {
        // Act
        /** @var PendingCommand $command */
        $command = $this->artisan('example:subtract', [
            'first' => '10',
            'second' => '3',
        ]);

        // Assert
        $command->assertSuccessful()
        ->expectsOutputToContain('Результат вычитания:')
        ->expectsOutputToContain("| 10 | 3 | 7 |\n| 3 | 10 | -7 |");
    }

    public function testEqualNumbersThrowsException(): void
    {
        $this->expectException(InvalidSubtractNumbersException::class);
        $this->expectExceptionMessage('Cannot subtract equal numbers.');

        // Act
        /** @var PendingCommand $command */
        $command = $this->artisan('example:subtract', [
            'first' => '5',
            'second' => '5',
        ]);

        // Assert
        $command->assertExitCode(1);
    }
}
