# Технический план реализации: Базовая структура и аутентификация

## Архитектурные решения

Реализация разделена на два модуля:
1. **Core**: базовая интеграция модульной структуры с Laravel и web-маршрутизация.
2. **Auth**: web-аутентификация пользователей.

### Слои модуля Auth (фактическая структура)
- **Domain**: сущность `User`, DTO запросов.
- **Application**: UseCase + команды/запросы (Command/Query) для доступа к данным.
- **Presentation**: HTTP-контроллеры и Blade-представления.

Отклонение от классической схемы: отдельного **Infrastructure** слоя нет,
доступ к БД выполняется из Application через фасад `DB`.

## Модель предметной области

### Сущности (Domain/Entity)
- `User`: `id` (Integer), `login`, `password`, `firstName`, `middleName`, `lastName`, `email`, `userType`, `active`, `createdAt`.

### DTO (Domain/Request)
- `RegisterRequest`: `login`, `password`, `firstName`, `middleName`, `lastName`, `email`.
- `LoginRequest`: `email`, `password`, `remember`.

## Сценарии интеграции
- Модуль `Auth` является первичным. Другие модули будут зависеть от `Auth`
  для получения текущего пользователя через `Auth::user()`.

## Изменяемые файлы

### Новые файлы:
- `backend/src/Core/Presentation/Config/RouteServiceProvider.php`
- `backend/src/Auth/Domain/Entity/User.php`
- `backend/src/Auth/Domain/Request/RegisterRequest.php`
- `backend/src/Auth/Domain/Request/LoginRequest.php`
- `backend/src/Auth/Application/Command/RegisterUserCommand.php`
- `backend/src/Auth/Application/Query/GetUserByEmailQuery.php`
- `backend/src/Auth/Application/Query/GetUserByIdQuery.php`
- `backend/src/Auth/Application/UseCase/RegisterUser.php`
- `backend/src/Auth/Application/UseCase/LoginUser.php`
- `backend/src/Auth/Presentation/Http/Controller/RegisterController.php`
- `backend/src/Auth/Presentation/Http/Controller/LoginController.php`
- `backend/src/Auth/Presentation/Http/Controller/LogoutController.php`
- `backend/src/Auth/Presentation/Http/Controller/DashboardController.php`
- `backend/src/Auth/Presentation/Config/AuthServiceProvider.php`
- `backend/src/Auth/Presentation/View/layouts/app.blade.php`
- `backend/src/Auth/Presentation/View/register.blade.php`
- `backend/src/Auth/Presentation/View/login.blade.php`
- `backend/src/Auth/Presentation/View/dashboard.blade.php`

### Изменяемые файлы:
- `backend/routes/web.php`
- `backend/bootstrap/providers.php`

## Последовательность действий

1. **Core / маршрутизация**:
   - Подключить `RouteServiceProvider` и web-группу маршрутов.
   - Зарегистрировать провайдер в `backend/bootstrap/providers.php`.

2. **Domain Layer (Auth)**:
   - Создать сущность `User`.
   - Создать DTO `RegisterRequest` и `LoginRequest`.

3. **Application Layer (Auth)**:
   - Реализовать `RegisterUser` UseCase: проверка email, хеширование пароля,
     сохранение пользователя.
   - Реализовать `LoginUser` UseCase: проверка учетных данных.
   - Реализовать CQRS-слой: `RegisterUserCommand`, `GetUserByEmailQuery`,
     `GetUserByIdQuery`.

4. **Presentation Layer (Auth)**:
   - Создать контроллеры для регистрации/входа/выхода/dashboard.
   - Настроить маршруты в `web.php`.
   - Создать Blade-шаблоны.

5. **База данных**:
   - Использовать таблицу `gen_user`, создаваемую миграцией импорта структуры
     (этап `0901_S0`).

## Диаграмма потока данных (регистрация)
`User -> RegisterController -> RegisterUser UseCase -> RegisterUserCommand -> SQLite`

## Миграции и конфигурация
- Таблица `gen_user` создаётся миграцией импорта структуры БД.
- Конфигурация `auth` остаётся стандартной, используется guard `web`.

## Риски и альтернативы
- **Риск**: отклонение от Clean Architecture из-за прямого доступа к БД в Application.
- **Решение**: зафиксировать отклонение и компенсировать тестами.

## Чек-лист архитектурного соответствия
- [ ] Логика аутентификации вынесена в UseCases.
- [ ] Контроллеры не содержат бизнес-логики.
- [ ] Доступ к БД оформлен командами/запросами (CQRS).
- [ ] Используются DTO для передачи данных.
