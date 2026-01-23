<?php

declare(strict_types=1);

namespace App\DatabaseMigration\Presentation\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

/**
 * Контроллер для проверки статуса базы данных.
 */
final class DatabaseStatusController extends Controller
{
    /**
     * Проверить статус базы данных.
     */
    public function status(): JsonResponse
    {
        // TODO: Реализовать проверку статуса на этапе 6
        return response()->json([
            'status' => 'ok',
            'message' => 'TODO: Implement database status check',
        ]);
    }
}
