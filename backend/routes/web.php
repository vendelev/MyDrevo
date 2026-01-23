<?php

declare(strict_types=1);

use App\Example\Presentation\Http\Controller\ExampleController;
use Illuminate\Support\Facades\Route;

Route::get('/examples/{id}', [ExampleController::class, 'show'])
    ->name('examples.show')
    ->middleware('auth');

