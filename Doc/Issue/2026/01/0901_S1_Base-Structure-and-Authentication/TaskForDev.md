# Технический план реализации: Базовая структура и аутентификация

## Архитектурные решения

Реализация будет разделена на два этапа:
1. **Core**: Базовые интерфейсы и обертки для работы с Laravel.
2. **Auth Module**: Реализация логики аутентификации.

### Слои модуля Auth:
- **Domain**: Сущность `User`, интерфейс репозитория, DTO для запросов/ответов.
- **Application**: UseCases для регистрации, входа и выхода. Команды и запросы для работы с БД.
- **Infrastructure**: Реализация репозитория на базе Eloquent.
- **Presentation**: Контроллеры для Web-интерфейса, Middleware для защиты маршрутов.

## Модель предметной области

### Сущности (Domain/Entity)
- `User`: `id` (UUID), `name`, `email`, `password`.

### Интерфейсы (Domain)
- `UserRepositoryInterface`: Методы `save(User $user)`, `findByEmail(string $email)`, `findById(string $id)`.

### DTO (Domain/Request & Response)
- `RegisterRequest`: `name`, `email`, `password`.
- `LoginRequest`: `email`, `password`, `remember`.
- `UserResponse`: `id`, `name`, `email`.

## Сценарии интеграции
- Модуль `Auth` является первичным. Другие модули будут зависеть от `Auth` для получения текущего пользователя через `Auth::user()` или кастомные адаптеры.

## Изменяемые файлы

### Новые файлы:
- `backend/src/Auth/Domain/Entity/User.php`
- `backend/src/Auth/Domain/UserRepositoryInterface.php`
- `backend/src/Auth/Domain/Request/RegisterRequest.php`
- `backend/src/Auth/Domain/Request/LoginRequest.php`
- `backend/src/Auth/Domain/Response/UserResponse.php`
- `backend/src/Auth/Application/UseCase/RegisterUser.php`
- `backend/src/Auth/Application/UseCase/LoginUser.php`
- `backend/src/Auth/Application/UseCase/LogoutUser.php`
- `backend/src/Auth/Infrastructure/Repository/EloquentUserRepository.php`
- `backend/src/Auth/Presentation/Http/Controller/RegisterController.php`
- `backend/src/Auth/Presentation/Http/Controller/LoginController.php`
- `backend/src/Auth/Presentation/Http/Controller/DashboardController.php`
- `backend/src/Auth/Presentation/Config/AuthServiceProvider.php`

### Изменяемые файлы:
- `backend/routes/web.php`
- `backend/config/auth.php`
- `backend/database/migrations/0001_01_01_000000_create_users_table.php` (стандартная миграция Laravel)

## Последовательность действий

1.  **Настройка БД**:
    - Убедиться, что в `backend/.env` настроен SQLite.
    - Выполнить `make php-run CMD="php artisan migrate"`.

2.  **Domain Layer (Auth)**:
    - Создать сущность `User` и интерфейс репозитория.
    - Создать DTO для запросов и ответов.

3.  **Infrastructure Layer (Auth)**:
    - Реализовать `EloquentUserRepository`.
    - Настроить `AuthServiceProvider` для связывания интерфейса с реализацией.

4.  **Application Layer (Auth)**:
    - Реализовать `RegisterUser` UseCase: валидация, хеширование пароля, сохранение, аутентификация.
    - Реализовать `LoginUser` UseCase: проверка учетных данных, создание сессии.
    - Реализовать `LogoutUser` UseCase: завершение сессии.

5.  **Presentation Layer (Auth)**:
    - Создать контроллеры, вызывающие соответствующие UseCases.
    - Настроить маршруты в `web.php`.
    - Создать Blade-шаблоны для форм (Login, Register, Dashboard).

## Диаграмма потока данных (регистрация)
`User -> RegisterController -> RegisterUser UseCase -> UserRepository -> SQLite`

## Миграции и конфигурация
- Использование стандартной таблицы `users`, но с UUID в качестве первичного ключа.
- Настройка `guards` и `providers` в `config/auth.php` для использования нашего модуля.

## Риски и альтернативы
- **Риск**: Конфликт со встроенной системой аутентификации Laravel (Breeze/Jetstream).
- **Решение**: Не использовать стартовые наборы, реализовать логику вручную для полного контроля над архитектурой.

## Чек-лист архитектурного соответствия
- [ ] Логика аутентификации вынесена в UseCases.
- [ ] Контроллеры не содержат бизнес-логики.
- [ ] Инфраструктура скрыта за интерфейсами Domain.
- [ ] Используются DTO для передачи данных.
