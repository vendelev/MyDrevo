<?php

declare(strict_types=1);

namespace App\Example\Presentation\Http\Controller;

use App\Example\Application\Factory\ExampleRequestFactory;
use App\Example\Application\UseCase\ExampleUseCase;
use App\Example\Domain\Exception\ExampleNotFoundException;
use App\Example\Domain\Response\ExampleResponse;
use App\Example\Presentation\Http\Middleware\ExampleMiddleware;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View as ViewFacade;
use Illuminate\Validation\ValidationException;
use JsonException;

final readonly class ExampleController
{
    public function __construct(
        private ExampleUseCase $exampleUseCase,
        private ExampleRequestFactory $requestFactory,
    ) {
    }

    /**
     * @return list<class-string>
     */
    public static function middleware(): array
    {
        return [ExampleMiddleware::class];
    }

    /**
     * @throws JsonException
     * @throws ValidationException
     */
    public function create(Request $request): JsonResponse
    {
        $createRequest = $this->requestFactory->createRequest(
            $request->all(),
            (int)Auth::id()
        );

        $exampleId = $this->exampleUseCase->createExample($createRequest);

        return response()->json(new ExampleResponse($exampleId));
    }

    public function show(int $id): View
    {
        try {
            return ViewFacade::make('example::dashboard', [
                'example' => $this->exampleUseCase->getExampleViewData($id)
            ]);
        } catch (ExampleNotFoundException) {
            abort(404);
        }
    }
}
