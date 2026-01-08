<?php

declare(strict_types=1);

namespace Tests;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

/**
 * @SuppressWarnings(NumberOfChildren)
 */
abstract class TestCase extends BaseTestCase
{
    use RefreshDatabase;

    protected function refreshTestDatabase(): void
    {
        $this->beginDatabaseTransaction();
    }

    /**
     * @template TObject
     *
     * @param class-string<TObject> $className
     * @param array<string, mixed> $parameters
     *
     * @return TObject
     * @throws BindingResolutionException
     */
    protected function service(string $className, array $parameters = []): mixed
    {
        return $this->app->makeWith($className, $parameters);
    }
}
