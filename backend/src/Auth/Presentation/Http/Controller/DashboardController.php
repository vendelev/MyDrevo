<?php

declare(strict_types=1);

namespace App\Auth\Presentation\Http\Controller;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\View as ViewFacade;

final class DashboardController
{
    public function index(): View
    {
        // Проверка аутентификации через Laravel middleware
        return ViewFacade::make('auth::dashboard');
    }
}
