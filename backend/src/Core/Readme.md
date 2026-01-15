# Модуль Core: базовая инфраструктура приложения

## Назначение

Модуль **Core** содержит минимальный общепроектный код. Он нужен, чтобы
корректно интегрировать модульную структуру `backend/src/*` с Laravel.

В рамках этапа `0901_S1` (базовая структура и аутентификация) Core отвечает за
подключение web-маршрутов приложения.

## 1. Описание архитектуры и структуры модуля

Core следует общим правилам Clean Architecture.
На текущем этапе содержит только слой **Presentation**.

Структура:

```text
backend/src/Core/
└── Presentation/
    └── Config/
        └── RouteServiceProvider.php
```

## 2. Описание предметной области (Domain)

Предметная область в модуле Core на данном этапе отсутствует.
Domain-объектов, сущностей и бизнес-правил нет.

## 3. Описание реализации бизнес-логики (Application)

Application-слой в модуле Core на данном этапе отсутствует.

## 4. Документация API интерфейсов (Presentation)

### RouteServiceProvider

Класс
[`RouteServiceProvider`](backend/src/Core/Presentation/Config/RouteServiceProvider.php:10)
подключается в список провайдеров Laravel
(см. [`backend/bootstrap/providers.php`](backend/bootstrap/providers.php:1)).

Функции провайдера:

- регистрирует web-группу маршрутов;
- подключает файл маршрутов через `base_path('routes/web.php')`.

См. реализацию
[`RouteServiceProvider::mapWebRoutes()`](backend/src/Core/Presentation/Config/RouteServiceProvider.php:17).

Фактические web-маршруты определены в
[`backend/routes/web.php`](backend/routes/web.php:1).
На данном этапе они включают маршруты аутентификации/личного кабинета модуля
Auth.

## 5. Интеграция с внешними системами (Infrastructure)

Внешние интеграции отсутствуют.

## 6. Зависимости

- Laravel Framework — приложение на базе Laravel 12
  (см. [`backend/composer.json`](backend/composer.json:1)).
- Модуль Auth зависит от Core на уровне маршрутизации:
  Core подключает web routes, где используются контроллеры Auth.

## 8. Тестирование модуля

Отдельные тесты для Core в текущей реализации не выделены.

Проверка корректности маршрутизации покрывается E2E/Presentation тестами
модуля Auth.
См. [`WebAuthenticationFlowTest`](backend/tests/Suite/Auth/E2E/WebAuthenticationFlowTest.php:11).

## 9. Сценарии использования

- При старте приложения Laravel загружает провайдеры из
  [`backend/bootstrap/providers.php`](backend/bootstrap/providers.php:1).
- Core подключает web-маршруты приложения из
  [`backend/routes/web.php`](backend/routes/web.php:1).
  Тем самым активируются web-интерфейсы модулей
  (на данном этапе — Auth).
