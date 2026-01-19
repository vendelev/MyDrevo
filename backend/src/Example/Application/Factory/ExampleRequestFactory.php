<?php

declare(strict_types=1);

namespace App\Example\Application\Factory;

use App\Example\Domain\Dto\Status;
use App\Example\Domain\Request\CreateExampleRequest;
use Illuminate\Contracts\Validation\Factory as ValidationFactoryInterface;
use Illuminate\Validation\ValidationException;

final readonly class ExampleRequestFactory
{
    public function __construct(
        private ValidationFactoryInterface $validator,
    ) {
    }

    /**
     * @param array<string, mixed> $json
     * @throws ValidationException
     */
    public function createRequest(array $json, int $userId): CreateExampleRequest
    {
        $validated = $this->validator->make(
            $json,
            [
                'name' => ['required', 'string'],
                'comment' => ['nullable', 'string'],
                'status' => ['required', 'string', 'in:' . Status::casesAsString()],
            ]
        )->validated();

        return new CreateExampleRequest(
            name: $validated['name'],
            comment: $validated['comment'],
            status: Status::from($validated['status']),
            userId: $userId
        );
    }
}
