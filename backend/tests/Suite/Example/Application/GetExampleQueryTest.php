<?php

declare(strict_types=1);

namespace Tests\Suite\Example\Application;

use App\Example\Application\Dto\ExampleDto;
use App\Example\Application\Query\GetExampleQuery;
use Illuminate\Database\ConnectionInterface;
use Illuminate\Database\Query\Builder;
use stdClass;
use Tests\TestCase;

final class GetExampleQueryTest extends TestCase
{
    public function testGetByIdWhenFound(): void
    {
        // Arrange
        $id = 123;
        $expectedName = 'Test Name';
        $expectedComment = 'Test Comment';

        $result = new stdClass();
        $result->name = $expectedName;
        $result->comment = $expectedComment;

        $queryBuilder = $this->createMock(Builder::class);
        $queryBuilder->expects($this->once())
            ->method('select')
            ->with(['name', 'comment'])
            ->willReturnSelf();
        $queryBuilder->expects($this->once())
            ->method('where')
            ->with('id', $id)
            ->willReturnSelf();
        $queryBuilder->expects($this->once())
            ->method('first')
            ->willReturn($result);

        $connection = $this->createMock(ConnectionInterface::class);
        $connection->expects($this->once())
            ->method('table')
            ->with('examples')
            ->willReturn($queryBuilder);

        $query = new GetExampleQuery($connection);

        // Act
        $dto = $query->getById($id);

        // Assert
        self::assertInstanceOf(ExampleDto::class, $dto);
        self::assertEquals($id, $dto->id);
        self::assertEquals($expectedName, $dto->name);
        self::assertEquals($expectedComment, $dto->comment);
    }

    public function testGetByIdWhenNotFound(): void
    {
        // Arrange
        $id = 123;

        $queryBuilder = $this->createMock(Builder::class);
        $queryBuilder->expects($this->once())
            ->method('select')
            ->with(['name', 'comment'])
            ->willReturnSelf();
        $queryBuilder->expects($this->once())
            ->method('where')
            ->with('id', $id)
            ->willReturnSelf();
        $queryBuilder->expects($this->once())
            ->method('first')
            ->willReturn(null);

        $connection = $this->createMock(ConnectionInterface::class);
        $connection->expects($this->once())
            ->method('table')
            ->with('examples')
            ->willReturn($queryBuilder);

        $query = new GetExampleQuery($connection);

        // Act
        $dto = $query->getById($id);

        // Assert
        self::assertNull($dto);
    }
}
