<?php

declare(strict_types=1);

namespace Tests\Suite\Auth\Presentation;

use App\Auth\Presentation\Http\Controller\LoginController;
use Illuminate\Support\ViewErrorBag;
use Tests\TestCase;

final class LoginControllerTest extends TestCase
{
    public function testShowLoginForm(): void
    {
        $controller = $this->service(LoginController::class);
        $view = $controller->showLoginForm();
        $view->with('errors', new ViewErrorBag());

        $content = $view->render();

        // Проверяем содержимое шаблона
        self::assertStringContainsString('Вход', $content);
        self::assertStringContainsString('Адрес электронной почты', $content);
        self::assertStringContainsString('Пароль', $content);
    }
}
