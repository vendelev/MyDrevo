<?php

declare(strict_types=1);

namespace Tests\Suite\Example\Application;

use App\Example\Application\UseCase\ExampleUseCase;
use App\Example\Domain\Dto\Status;
use App\Example\Domain\Entity\Example;
use App\Example\Domain\Exception\ExampleNotFoundException;
use App\Example\Domain\Request\CreateExampleRequest;
use Tests\Stub\ModelFactory\ExampleFactory;
use Tests\TestCase;

final class ExampleUseCaseTest extends TestCase
{
    /**
     * @throws \JsonException
     */
    public function testCreateExample(): void
    {
        // Arrange
        $request = new CreateExampleRequest(
            name: 'Test Name',
            comment: 'Test Comment',
            status: Status::ACTIVE,
            userId: 1,
        );

        $useCase = $this->service(ExampleUseCase::class);

        // Act
        $result = $useCase->createExample($request);

        // Assert
        self::assertGreaterThan(0, $result->value);
    }

    /**
     * @throws ExampleNotFoundException
     */
    public function testGetExampleViewDataWhenFound(): void
    {
        // Arrange
        /** @var Example $example */
        $example = ExampleFactory::new()->create();
        $useCase = $this->service(ExampleUseCase::class);

        // Act
        $result = $useCase->getExampleViewData($example->id);

        // Assert
        self::assertEquals($example->name, $result->name);
        self::assertEquals($example->comment, $result->comment);
    }

    /**
     * @throws ExampleNotFoundException
     */
    public function testGetExampleViewDataWhenNotFound(): void
    {
        // Arrange
        $id = 999;
        $useCase = $this->service(ExampleUseCase::class);

        // Act & Assert
        $this->expectException(ExampleNotFoundException::class);
        $this->expectExceptionMessage('Example with id 999 not found.');

        $useCase->getExampleViewData($id);
    }
}
