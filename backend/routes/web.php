<?php

declare(strict_types=1);

use App\Auth\Presentation\Http\Controller\DashboardController;
use App\Auth\Presentation\Http\Controller\LoginController;
use App\Auth\Presentation\Http\Controller\LogoutController;
use App\Auth\Presentation\Http\Controller\RegisterController;
use App\Example\Presentation\Http\Controller\ExampleController;
use Illuminate\Support\Facades\Route;

// Маршруты для аутентификации
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');

// Маршруты для dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard')
    ->middleware('auth');

// Маршруты для example
Route::middleware('auth')->group(function () {
    Route::get('/examples/{id}', [ExampleController::class, 'show'])
        ->name('examples.show');
});

