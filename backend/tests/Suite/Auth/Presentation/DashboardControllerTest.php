<?php

declare(strict_types=1);

namespace Tests\Suite\Auth\Presentation;

use App\Auth\Presentation\Http\Controller\DashboardController;
use Illuminate\Support\ViewErrorBag;
use Tests\TestCase;

final class DashboardControllerTest extends TestCase
{
    public function testDashboardControllerIndex(): void
    {
        $controller = $this->service(DashboardController::class);
        $view = $controller->index();
        $view->with('errors', new ViewErrorBag());

        $content = $view->render();

        // Проверяем содержимое шаблона
        self::assertStringContainsString('Добро пожаловать в панель управления', $content);
        self::assertStringContainsString('Вы успешно вошли в систему.', $content);
    }
}
