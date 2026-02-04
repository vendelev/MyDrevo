# Осознанные архитектурные компромиссы

Для упрощения реализации и ускорения разработки приняты следующие компромиссы относительно строгих принципов
Clean Architecture и CQRS.

---

## 1. Eloquent модели в Domain слое

### Стандарт Clean Architecture

ORM модели (например, Eloquent) должны располагаться в Infrastructure слое, так как они представляют собой технические
детали реализации доступа к данным.

### Наше решение

**Eloquent модели располагаются в `Domain/Entity`**

```php
// backend/src/Currency/Domain/Entity/CurrencyConversion.php
namespace App\Currency\Domain\Entity;

use Illuminate\Database\Eloquent\Model;

class CurrencyConversion extends Model
{
    // ...
}
```

### Почему принято это решение

1. **Упрощение**: Не требуется создавать отдельные классы для Domain Entity и Eloquent моделей
2. **Меньше кода**: Исключается необходимость в Mapper классах для преобразования между слоями
3. **Eloquent достаточно чист**: Eloquent ORM предоставляет достаточно абстрактный API, который не сильно связывает
   код с фреймворком
4. **Практичность**: Для большинства бизнес-задач такой подход не вызывает проблем

### Когда это становится проблемой

- Необходимость полной независимости от Laravel
- Миграция на другую ORM или базу данных
- Сложная бизнес-логика в Entity, не связанная с персистентностью

### Альтернатива (строгая Clean Architecture)

Если требуется строгое соответствие Clean Architecture:

**1. Создать чистые Domain Entity без зависимости от фреймворка:**

```php
// backend/src/Currency/Domain/Entity/CurrencyConversion.php
namespace App\Currency\Domain\Entity;

use DateTimeImmutable;

final readonly class CurrencyConversion
{
    public function __construct(
        public string $id,
        public Money $sourceAmount,
        public Money $targetAmount,
        public ExchangeRate $exchangeRate,
        public DateTimeImmutable $convertedAt,
    ) {}
}
```

**2. Eloquent модели в Infrastructure:**

```php
// backend/src/Currency/Infrastructure/Persistence/EloquentCurrencyConversion.php
namespace App\Currency\Infrastructure\Persistence;

use Illuminate\Database\Eloquent\Model;

class EloquentCurrencyConversion extends Model
{
    protected $table = 'currency_conversions';
}
```

**3. Mapper для преобразования:**

```php
// backend/src/Currency/Infrastructure/Persistence/CurrencyConversionMapper.php
namespace App\Currency\Infrastructure\Persistence;

class CurrencyConversionMapper
{
    public function toDomain(EloquentCurrencyConversion $model): CurrencyConversion
    {
        return new CurrencyConversion(
            id: $model->id,
            sourceAmount: new Money($model->source_amount, new CurrencyCode($model->source_currency)),
            // ...
        );
    }

    public function toEloquent(CurrencyConversion $entity): EloquentCurrencyConversion
    {
        $model = new EloquentCurrencyConversion();
        $model->id = $entity->id;
        $model->source_amount = $entity->sourceAmount->amount;
        // ...
        return $model;
    }
}
```

**Недостатки строгого подхода:**

- Значительно больше boilerplate кода
- Необходимость поддерживать синхронизацию между двумя представлениями одной сущности
- Усложнение для команды при небольших проектах

---

## 2. Command/Query работают с БД напрямую

### Стандарт CQRS

Команды и запросы должны работать через Repository интерфейсы, определенные в Domain слое.

### Наше решение

**Разрешаем прямые запросы к БД через Eloquent/Query Builder в Command и Query:**

```php
// backend/src/Currency/Application/Query/GetExchangeRatesQuery.php
namespace App\Currency\Application\Query;

use App\Currency\Domain\Entity\ExchangeRate;
use Illuminate\Support\Facades\DB;

class GetExchangeRatesQuery
{
    public function execute(string $baseCurrency): array
    {
        // Прямой запрос к БД без Repository
        return DB::table('exchange_rates')
            ->where('base_currency', $baseCurrency)
            ->get()
            ->toArray();
    }
}
```

### Почему принято это решение

1. **Eloquent Builder достаточно абстрактен**: Query Builder Laravel предоставляет удобный и относительно
   независимый API
2. **Избегаем Repository Explosion**: Не нужно создавать Repository для каждой таблицы
3. **Быстрая разработка**: Уменьшение количества классов и интерфейсов

### Когда НУЖНО использовать Repository

Repository интерфейс обязателен в следующих случаях:

1. . **Взаимодействие с внешними системами:**

   ```php
   interface ExchangeRateProviderInterface
   {
       public function getRate(CurrencyCode $from, CurrencyCode $to): ExchangeRate;
   }
   ```

2. **Агрегация данных из нескольких источников:**

   ```php
   interface ReportRepositoryInterface
   {
       public function generateSalesReport(DateRange $period): SalesReport;
   }
   ```

---

## 3. Упрощенная структура тестов

### Стандарт

Каждый компонент должен иметь соответствующий тест, структура тестов должна полностью повторять структуру модуля.

### Наше решение

Мы не требуем создавать тесты для:

- Простых DTO без логики
- Конфигурационных файлов
- Простых исключений (наследующих базовые классы без дополнительной логики)

### Почему

1. **Экономия времени**: Тесты простых DTO добавляют мало ценности
2. **Фокус на важном**: Концентрация на тестировании бизнес-логики
3. **Покрытие через интеграционные тесты**: DTO проверяются в составе UseCase тестов

### Что ОБЯЗАТЕЛЬНО тестировать

- ✅ Все компоненты Application слоя (UseCase, Command, Query, Service)
- ✅ Все компоненты Domain слоя с логикой (Entity, ValueObject с валидацией, Validation)
- ✅ Все компоненты Infrastructure слоя (Repository, Adapter)
- ✅ Все компоненты Presentation слоя (Controller, Listener, Console Command)

---

## Заключение

Эти компромиссы позволяют:

1. **Ускорить разработку** - меньше boilerplate кода
2. **Упростить поддержку** - меньше классов и интерфейсов
3. **Сохранить основные принципы** - разделение ответственности, тестируемость, читаемость

При этом система остается:

- Тестируемой (все компоненты можно покрыть тестами)
- Поддерживаемой (четкое разделение на слои и модули)
- Расширяемой (легко добавлять новый функционал)

**Если проект вырастет и потребуется строгое соответствие Clean Architecture**, миграция возможна поэтапно:

1. Выделить критичные модули
2. Создать для них чистые Domain Entity
3. Добавить Mapper классы
4. Постепенно мигрировать остальные модули

**Документ для обсуждения**: Если у вас есть сомнения в правильности этих компромиссов для вашего проекта, обсудите
их с командой и архитектором.
