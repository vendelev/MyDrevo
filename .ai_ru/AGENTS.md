# Информация о проекте

## Общение

Все ответы и взаимодействие на **русском языке**.

## Сводка

Учебный проект для создания сайта гениалогического древа используя Specification-Driven Development и AI, используя Laravel и полной контейнеризацией через Docker.

### Основные компоненты
- **Backend API**: Сервис на Laravel с Clean Architecture и CQRS
- **Database**: SQLite с миграциями через Laravel

### Команды Makefile

Проект использует Makefile для упрощения выполнения частых задач разработки:

- `make install` - Собрать и запустить образы, composer install, создание тестовой БД.
- `make up` - Запуск контейнеров.
- `make down` - Остановить и удалить контейнеры.
- `make update` - Пересобрать и перезапустить образы, composer install.
- `make php-cli` - Bash PHP контейнера.
- `make php-log` - Логи PHP контейнера.
- `make php-run CMD="..."` - Выполнить команду в PHP контейнере. Например, `make php-run CMD="php artisan migrate"`

---

## Backend (PHP/Laravel)

**Конфигурация**: `backend/composer.json`

- **Язык**: PHP 8.5.1
- **Фреймворк**: Laravel 12.46.0
- **Сборка**: Composer
- **Структура**: Модульный монолит с Clean Architecture и CQRS
- **Тесты**: Unit, Integration, E2E
- **Статический анализ**: PHPStan, PHP_CodeSniffer, Rector

### Архитектура

- Правила архитектуры в [Architecture.md](/.ai/Rule/Architecture.md)

### Code Style

- Особенности работы с PHP в этом проекте в [CodeHints.md](/.ai/Rule/CodeHints.md)
- Принятый в команде стиль кода в [CodeStyle.md](/.ai/Rule/CodeStyle.md)

### Тестирование

- Рекомендации по написанию тестов в [Testing.md](/.ai/Rule/Testing.md)

### Переменные окружения

- **Backend**: `backend/.env.example` — шаблон с комментариями
- **Backend**: `backend/.env.testing` — переменные для проведения тестов
- **Backend**: `backend/.env` — переменные с реальными значениями

### Структура директорий в backend

```text
backend/
├── src/
│   ├── Core/           (Общепроектный код)
│   └── {ModuleName}/   (Модули функциональности)
├── database/
│   └── migrations/     (Миграции БД)
├── tests/
│   ├── Suite/          (Все тесты приложения)
│   └── Stub/           (Фикстуры и тестовые данные)
└── composer.json       (Зависимости)
```

---

## База данных

- **СУБД**: SQLite
- **Управление схемой**: Laravel миграции
- **Конфигурация**: Backend переменные окружения
- **Тестовая БД**: Отдельная конфигурация для тестов
