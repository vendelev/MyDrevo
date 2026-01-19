<?php

declare(strict_types=1);

namespace Tests\Suite\Example\Presentation;

use App\Example\Presentation\Http\Middleware\ExampleMiddleware;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Tests\TestCase;

final class ExampleMiddlewareTest extends TestCase
{
    public function testMiddlewarePassesRequest(): void
    {
        // Arrange
        $request = Request::create('/test', 'GET');
        $middleware = new ExampleMiddleware();

        $executed = false;
        $next = function ($req) use (&$executed): ResponseFactory|Response {
            $executed = true;
            return response('OK');
        };

        // Act
        $response = $middleware->handle($request, $next);

        // Assert
        self::assertTrue($executed);
        self::assertEquals('OK', $response->getContent());
    }
}
