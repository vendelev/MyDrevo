<?php

declare(strict_types=1);

namespace Tests\Suite\Example\Application;

use App\Example\Application\Command\ExampleOutboxCommand;
use App\Example\Application\Dto\ExampleDto;
use Illuminate\Database\ConnectionInterface;
use Illuminate\Database\Query\Builder;
use JsonException;
use Tests\TestCase;

final class ExampleOutboxCommandTest extends TestCase
{
    /**
     * @throws JsonException
     */
    public function testInsert(): void
    {
        // Arrange
        $data = new ExampleDto(123, 'Test Name', 'Test Comment');
        $expectedId = 456;

        $tableBuilder = $this->createMock(Builder::class);
        $tableBuilder->expects($this->once())
            ->method('insertGetId')
            ->with([
                'serialized_data' => json_encode($data, JSON_THROW_ON_ERROR),
                'created' => date('Y-m-d'),
                'updated' => date('Y-m-d'),
            ], 'outbox_id')
            ->willReturn($expectedId);

        $connection = $this->createMock(ConnectionInterface::class);
        $connection->expects($this->once())
            ->method('table')
            ->with('example_outbox')
            ->willReturn($tableBuilder);

        $command = new ExampleOutboxCommand($connection);

        // Act
        $result = $command->insert($data);

        // Assert
        self::assertEquals($expectedId, $result);
    }
}
