<?php

declare(strict_types=1);

namespace Tests\Suite\Example\Infrastructure;

use App\Example\Domain\Dto\CreateExampleDto;
use App\Example\Domain\Dto\Status;
use App\Example\Domain\Entity\Example;
use App\Example\Infrastructure\Repository\EloquentExampleRepository;
use DateTimeImmutable;
use Tests\TestCase;

final class EloquentExampleRepositoryTest extends TestCase
{
    public function testStore(): void
    {
        // Arrange
        $dto = new CreateExampleDto(
            name: 'Test Name',
            comment: 'Test Comment',
            status: Status::ACTIVE,
            userId: 1,
            createdAt: new DateTimeImmutable(),
        );

        $repository = new EloquentExampleRepository();

        // Act
        $id = $repository->store($dto);

        // Assert
        self::assertGreaterThan(0, $id);

        $saved = Example::find($id);
        self::assertNotNull($saved);
        self::assertEquals($dto->name, $saved->name);
        self::assertEquals($dto->comment, $saved->comment);
        self::assertEquals($dto->userId, $saved->user_id);
    }
}
