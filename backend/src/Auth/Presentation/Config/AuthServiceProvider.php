<?php

declare(strict_types=1);

namespace App\Auth\Presentation\Config;

use Illuminate\Support\ServiceProvider;

final class AuthServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../../Presentation/View', 'auth');
    }
}
