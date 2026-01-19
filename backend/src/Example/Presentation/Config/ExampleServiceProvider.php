<?php

declare(strict_types=1);

namespace App\Example\Presentation\Config;

use App\Example\Domain\Event\ExampleCreated;
use App\Example\Domain\ExampleRepositoryInterface;
use App\Example\Domain\ExternalLoggerInterface;
use App\Example\Infrastructure\Adapter\ClickhouseLogger;
use App\Example\Infrastructure\Repository\EloquentExampleRepository;
use App\Example\Presentation\Console\SubtractExampleCommand;
use App\Example\Presentation\Listener\ExampleCreatedListener;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Override;

final class ExampleServiceProvider extends ServiceProvider
{
    #[Override]
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/example.php', 'example');

        $this->app->bind(ExampleRepositoryInterface::class, EloquentExampleRepository::class);

        $this->app->bind(ExternalLoggerInterface::class, ClickhouseLogger::class);
        $this->app->when(ClickhouseLogger::class)->needs('$apiKey')->giveConfig('example.apiKey');
    }

    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../../Presentation/Http/View', 'example');

        Event::listen(events: [ExampleCreated::class], listener: ExampleCreatedListener::class);

        $this->commands([SubtractExampleCommand::class]);
    }
}
