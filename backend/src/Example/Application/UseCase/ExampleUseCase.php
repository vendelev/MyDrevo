<?php

declare(strict_types=1);

namespace App\Example\Application\UseCase;

use App\Example\Application\Command\ExampleOutboxCommand;
use App\Example\Application\Dto\ExampleDto;
use App\Example\Application\Query\GetExampleQuery;
use App\Example\Domain\Dto\CreateExampleDto;
use App\Example\Domain\Event\ExampleCreated;
use App\Example\Domain\ExampleRepositoryInterface;
use App\Example\Domain\Exception\ExampleNotFoundException;
use App\Example\Domain\Request\CreateExampleRequest;
use App\Example\Domain\ValueObject\CreatedIdVO;
use DateTimeImmutable;
use Illuminate\Contracts\Events\Dispatcher;
use JsonException;

final readonly class ExampleUseCase
{
    public function __construct(
        private ExampleRepositoryInterface $repository,
        private ExampleOutboxCommand $outboxCommand,
        private GetExampleQuery $exampleQuery,
        private Dispatcher $dispatcher,
    ) {
    }

    /**
     * @throws JsonException
     */
    public function createExample(CreateExampleRequest $request): CreatedIdVO
    {
        $example = new CreateExampleDto(
            name: $request->name,
            comment: $request->comment,
            status: $request->status,
            userId: $request->userId,
            createdAt: new DateTimeImmutable(),
        );

        $id = $this->repository->store($example);

        $this->outboxCommand->insert(new ExampleDto($id, $request->name, $request->comment));
        $this->dispatcher->dispatch(new ExampleCreated($id, $request->userId));

        return new CreatedIdVO($id);
    }

    /**
     * @throws ExampleNotFoundException
     */
    public function getExampleViewData(int $id): ExampleDto
    {
        $example = $this->exampleQuery->getById($id);

        if (!$example instanceof ExampleDto) {
            throw ExampleNotFoundException::byId($id);
        }

        return $example;
    }
}
