<?php

declare(strict_types=1);

namespace Tests\Suite\Auth\Presentation;

use App\Auth\Presentation\Http\Controller\RegisterController;
use Illuminate\Support\ViewErrorBag;
use Tests\TestCase;

final class RegisterControllerTest extends TestCase
{
    public function testShowRegistrationForm(): void
    {
        $controller = $this->service(RegisterController::class);
        $view = $controller->showRegistrationForm();
        $view->with('errors', new ViewErrorBag());

        $content = $view->render();

        // Проверяем содержимое шаблона
        self::assertStringContainsString('Регистрация', $content);
        self::assertStringContainsString('Адрес электронной почты', $content);
        self::assertStringContainsString('Пароль', $content);
        self::assertStringContainsString('Имя', $content);
    }
}
