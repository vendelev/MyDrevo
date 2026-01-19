<?php

declare(strict_types=1);

namespace App\Core\Presentation\Config;

use Illuminate\Support\ServiceProvider;

final class CoreServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../../Presentation/View', 'core');
        $this->loadViewsFrom(__DIR__ . '/../../Presentation/View/errors', 'errors');
    }
}
