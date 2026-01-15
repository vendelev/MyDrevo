# Технический план для разработчика: Импорт структуры базы данных из MySQL в SQLite

## 1. Цель задачи

Преобразовать существующую схему базы данных из MySQL-формата в SQLite-совместимый формат и интегрировать её в систему миграций Laravel. Миграция должна создавать все необходимые таблицы для функционирования системы генеалогического древа.

## 2. Архитектурные принципы

- Следование Clean Architecture: миграции относятся к инфраструктурному слою ([Architecture.md](/Doc/Rule/Architecture.md))
- Использование CQRS: миграции относятся к командной части системы ([Architecture.md](/Doc/Rule/Architecture.md))
- Модульный монолит: миграции должны быть независимыми и изолированными ([Architecture.md](/Doc/Rule/Architecture.md))
- Соответствие принятому в проекте стилю кодирования ([CodeStyle.md](/Doc/Rule/CodeStyle.md))

## 3. Анализ исходной структуры

Исходная структура базы данных находится в файле `backend/database/migrations/structure.sql`. Основные сущности:
- `gen_user` - пользователи системы
- `gen_person` - персоны генеалогического древа
- `gen_name`, `gen_name_lang` - справочник имён
- `gen_surname`, `gen_surname_lang` - справочник фамилий
- `gen_relation` - отношения между персонами
- `gen_menu` - элементы меню
- `gen_message`, `gen_message_text` - системные сообщения
- `gen_user_right` - права пользователей

## 4. План реализации

### Шаг 1: Подготовка окружения
- Убедиться, что в `backend/.env` настроено подключение к SQLite
- Проверить наличие и содержимое файла `backend/database/migrations/structure.sql`

### Шаг 2: Создание миграции
- Создать новую миграцию с префиксом даты и времени, например: `2026_01_15_000000_import_database_structure.php`
- Использовать команду Laravel: `php artisan make:migration import_database_structure`

### Шаг 3: Конвертация DDL-инструкций
- Преобразовать MySQL-специфичный синтаксис в SQLite-совместимый:
  - `int unsigned` → `integer`
  - `varchar(n)` → `text`
  - `text` → `text`
  - `datetime` → `datetime`
  - Удалить специфичные для MySQL параметры: `CHARSET=utf8`, `ENGINE=InnoDB`, `AUTO_INCREMENT`
  - Преобразовать `PRIMARY KEY` и `UNIQUE` ограничения
  - Преобразовать `FOREIGN KEY` ограничения с учётом особенностей SQLite

### Шаг 4: Реализация миграции
```php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ImportDatabaseStructure extends Migration
{
    public function up(): void
    {
        // Включить поддержку внешних ключей в SQLite
        DB::statement('PRAGMA foreign_keys = ON;');
        
        // Создать таблицу gen_user
        Schema::create('gen_user', function (Blueprint $table) {
            $table->id();
            $table->string('login')->unique();
            $table->string('password');
            $table->string('fio');
            $table->string('email')->unique();
            $table->timestamps();
        });
        
        // Создать таблицу gen_person
        Schema::create('gen_person', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('middle_name')->nullable();
            $table->date('birth_date')->nullable();
            $table->date('death_date')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->timestamps();
            
            $table->foreign('created_by')->references('id')->on('gen_user')->onDelete('cascade');
        });
        
        // Создать остальные таблицы аналогичным образом...
        // gen_name, gen_name_lang, gen_surname, gen_surname_lang,
        // gen_relation, gen_menu, gen_message, gen_message_text, gen_user_right
    }

    public function down(): void
    {
        // Удалить таблицы в обратном порядке для соблюдения зависимостей
        Schema::dropIfExists('gen_user_right');
        Schema::dropIfExists('gen_message_text');
        Schema::dropIfExists('gen_message');
        Schema::dropIfExists('gen_menu');
        Schema::dropIfExists('gen_relation');
        Schema::dropIfExists('gen_surname_lang');
        Schema::dropIfExists('gen_surname');
        Schema::dropIfExists('gen_name_lang');
        Schema::dropIfExists('gen_name');
        Schema::dropIfExists('gen_person');
        Schema::dropIfExists('gen_user');
    }
}
```

### Шаг 5: Обеспечение идемпотентности
- Добавить проверку существования таблиц перед созданием:
```php
if (!Schema::hasTable('gen_user')) {
    Schema::create('gen_user', function (Blueprint $table) {
        // Определение таблицы
    });
}
```

### Шаг 6: Настройка порядка выполнения
- Убедиться, что миграция имеет префикс даты, предшествующий другим миграциям
- Проверить порядок выполнения миграций командой: `php artisan migrate:status`

## 5. Особенности SQLite

- Включить поддержку внешних ключей: `PRAGMA foreign_keys = ON;`
- SQLite не поддерживает `unsigned` типы, использовать `integer` вместо `int unsigned`
- SQLite автоматически управляет автоинкрементом для `id` полей
- Ограничения `UNIQUE` и `PRIMARY KEY` работают аналогично MySQL
- Индексы создаются автоматически для `PRIMARY KEY` и `UNIQUE` полей

## 6. Критерии приемки

1. Миграция успешно создает все таблицы из `structure.sql` при выполнении `php artisan migrate`
2. Все первичные ключи, уникальные ограничения и индексы корректно перенесены
3. Типы данных адекватно преобразованы
4. Поддержка внешних ключей включена в SQLite
5. Миграция проходит успешно на чистой базе данных
6. Миграция идемпотентна и безопасна для повторного выполнения
7. Код миграции соответствует стандартам проекта (CodeStyle.md)

## 7. Риски и меры по их минимизации

| Риск | Мера по минимизации |
|------|-------------------|
| Потеря данных при конвертации | Тестирование миграции на копии данных |
| Ошибки типов данных | Тщательная проверка соответствия типов |
| Проблемы с внешними ключами | Явное включение поддержки foreign keys |
| Производительность индексов | Проверка производительности запросов |
| Ограничения SQLite | Тестирование всех функций на SQLite |

## 8. Зависимости

- Наличие файла `backend/database/migrations/structure.sql`
- Корректная настройка подключения к SQLite в `backend/.env`
- Работоспособность системы миграций Laravel

## 9. Команды для проверки

```bash
# Создание миграции
make php-run CMD="php artisan make:migration import_database_structure"

# Проверка статуса миграций
make php-run CMD="php artisan migrate:status"

# Выполнение миграций
make php-run CMD="php artisan migrate"

# Откат миграций
make php-run CMD="php artisan migrate:rollback"

# Полная очистка и повторное выполнение
make php-run CMD="php artisan migrate:fresh"
```

## 10. Документация

- [Laravel Migrations](https://laravel.com/docs/12.x/migrations)
- [SQLite Foreign Keys](https://www.sqlite.org/foreignkeys.html)
- [MySQL to SQLite Conversion](https://www.sqlitetutorial.net/sqlite-vs-mysql/)