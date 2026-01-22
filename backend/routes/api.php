<?php

declare(strict_types=1);

use App\DatabaseMigration\Presentation\Http\Controllers\DatabaseStatusController;
use App\Example\Presentation\Http\Controller\ExampleController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth')->group(function () {
    Route::post('/examples', [ExampleController::class, 'create']);
});

// Статус базы данных
Route::get('/status', [DatabaseStatusController::class, 'status']);
