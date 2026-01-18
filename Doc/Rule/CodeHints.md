# Подсказки при работе с PHP кодом

## Практические рекомендации

### ✅ ДЕЛАЙ

- Проверяй соседние файлы перед реализацией (соглашения, импорты, библиотеки).
- Используй типизацию везде (параметры, возвращаемые значения).
- Создавай интерфейсы когда нужна инверсия зависимостей.
- Выноси логику парсинга и валидации из Controller.
- Используй публичные readonly свойства в __construct вместо геттеров, когда нет необходимости в дополнительной логике.
- Делай Entity и ValueObject immutable (неизменяемыми) добавляя модификатор final.
- Всегда используй внедрение зависимостей через конструктор.

### ❌ НЕ ДЕЛАЙ

- Не использует Eloquent модели напрямую в Application слое.
- Не создавай интерфейсы если всего одна реализация.
- Не передавай Request-laravel между слоями (используй DTO).
- Не загружай неиспользуемые зависимости в конструктор.
- Не используй `app()` для получения экземпляров классов в контроллерах и других местах.
- Не используй в `$this->app->singleton` ServiceProvider.

## Примеры-шаблоны файлов модуля

### Application

- Команда для обработки исходящих сообщений - [`ExampleOutboxCommand.php`](../../backend/src/Example/Application/Command/ExampleOutboxCommand.php)
- DTO для рассчитанного значения - [`Calculated.php`](../../backend/src/Example/Application/Dto/Calculated.php)
- Простое DTO - [`ExampleDto.php`](../../backend/src/Example/Application/Dto/ExampleDto.php)
- Фабрика для создания запросов примеров - [`ExampleRequestFactory.php`](../../backend/src/Example/Application/Factory/ExampleRequestFactory.php)
- Запрос для получения данных - [`GetExampleQuery.php`](../../backend/src/Example/Application/Query/GetExampleQuery.php)
- Responder для генерации отчета - [`ExampleMarkdownReportResponder.php`](../../backend/src/Example/Application/Responder/ExampleMarkdownReportResponder.php)
- Шаблон отчета в формате markdown - [`ExampleReport.md`](../../backend/src/Example/Application/Responder/Template/ExampleReport.md)
- Сервис для выполнения расчетов - [`ExampleCalcService.php`](../../backend/src/Example/Application/Service/ExampleCalcService.php)
- Варианты использования (создать и посмотреть) - [`ExampleUseCase.php`](../../backend/src/Example/Application/UseCase/ExampleUseCase.php)
- UseCase для выполнения операции вычитания - [`SubtractExampleUseCase.php`](../../backend/src/Example/Application/UseCase/SubtractExampleUseCase.php)

### Domain

- Документация обзора домена - [`overview.md`](../../backend/src/Example/Domain/Doc/overview.md)
- DTO для создания - [`CreateExampleDto.php`](../../backend/src/Example/Domain/Dto/CreateExampleDto.php)
- Enum - [`Status.php`](../../backend/src/Example/Domain/Dto/Status.php)
- Eloquent модель - [`Example.php`](../../backend/src/Example/Domain/Entity/Example.php)
- Событие: уведомление о создании - [`ExampleCreated.php`](../../backend/src/Example/Domain/Event/ExampleCreated.php)
- Исключение для ненайденного примера - [`ExampleNotFoundException.php`](../../backend/src/Example/Domain/Exception/ExampleNotFoundException.php)
- Исключение для недопустимых чисел - [`InvalidSubtractNumbersException.php`](../../backend/src/Example/Domain/Exception/InvalidSubtractNumbersException.php)
- DTO запрос на создание - [`CreateExampleRequest.php`](../../backend/src/Example/Domain/Request/CreateExampleRequest.php)
- DTO ответ - [`ExampleResponse.php`](../../backend/src/Example/Domain/Response/ExampleResponse.php)
- Value object для созданного ID - [`CreatedIdVO.php`](../../backend/src/Example/Domain/ValueObject/CreatedIdVO.php)
- ValueObject с валидацией - [`SubtractNumbersVO.php`](../../backend/src/Example/Domain/ValueObject/SubtractNumbersVO.php)
- Интерфейс внешнего логгера - [`ExternalLoggerInterface.php`](../../backend/src/Example/Domain/ExternalLoggerInterface.php)
- Интерфейс репозитория - [`ExampleRepositoryInterface.php`](../../backend/src/Example/Domain/ExampleRepositoryInterface.php)

### Infrastructure

- Адаптер для логирования в ClickHouse - [`ClickhouseLogger.php`](../../backend/src/Example/Infrastructure/Adapter/ClickhouseLogger.php)
- Репозиторий для работы с Eloquent - [`EloquentExampleRepository.php`](../../backend/src/Example/Infrastructure/Repository/EloquentExampleRepository.php)

### Presentation

- Конфигурационный файл - [`example.php`](../../backend/src/Example/Presentation/Config/example.php)
- Service provider для модуля - [`ExampleServiceProvider.php`](../../backend/src/Example/Presentation/Config/ExampleServiceProvider.php)
- Консольная команда - [`SubtractExampleCommand.php`](../../backend/src/Example/Presentation/Console/SubtractExampleCommand.php)
- Контроллер - [`ExampleController.php`](../../backend/src/Example/Presentation/Http/Controller/ExampleController.php)
- Middleware - [`ExampleMiddleware.php`](../../backend/src/Example/Presentation/Http/Middleware/ExampleMiddleware.php)
- Отображение данных в html - [`dashboard.blade.php`](../../backend/src/Example/Presentation/Http/View/dashboard.blade.php)
- Слушатель события - [`ExampleCreatedListener.php`](../../backend/src/Example/Presentation/Listener/ExampleCreatedListener.php)

### Корень модуля
- Конфигурация документации модуля - [`dochub.yaml`](../../backend/src/Example/dochub.yaml)
- Описание модуля - [`Readme.md`](../../backend/src/Example/Readme.md)

## Регистрация интерфейсов и реализаций

Для связи интерфейсов и их реализаций в контейнере зависимостей Laravel используйте метод `bind`:

```php
$this->app->bind(Interface::class, Implementation::class);
```

Это позволяет легко заменять реализации в тестах и соблюдает принцип инверсии зависимостей.

В остальных случаях объявлять класс в контейнере зависимостей НЕ ТРЕБУЕТСЯ.

## Регистрация ServiceProvider

Каждый модуль может иметь свой ServiceProvider для регистрации компонентов в контейнере зависимостей.

### Регистрация в bootstrap/providers.php

Все ServiceProvider должны быть зарегистрированы в файле `backend/bootstrap/providers.php`:

```php
<?php

use App\Core\Presentation\Config\CoreServiceProvider;
use App\Example\Presentation\Config\ExampleServiceProvider;

return [
    CoreServiceProvider::class,
    ExampleServiceProvider::class,
];
```

## Рекомендации по использованию переменных окружения

### Общие принципы

1. **Конфигурация через конфигурационные файлы**: Все параметры приложения должны быть доступны через систему конфигурации Laravel.
2. **Использование env() только в конфигурационных файлах**: Функция `env()` должна использоваться только в конфигурационных файлах в каталоге `config/` или в соответствующих файлах модулей.
3. **Избегайте прямого использования env() в бизнес-логике**: Никогда не используйте `env()` напрямую в классах Application, Domain или Infrastructure слоях.

### Правильное использование

1. Создайте конфигурационный файл в каталоге `Presentation/Config` вашего модуля, пример: [example.php](../../backend/src/Example/Presentation/Config/example.php)
2. Для передачи конфигурационных значений в классы используйте контейнер зависимостей в ServiceProvider, пример: [ExampleServiceProvider.php](../../backend/src/Example/Presentation/Config/ExampleServiceProvider.php)
3. В классах используйте внедрение зависимостей через параметры конструктора для получения значений, пример: [ClickhouseLogger.php](../../backend/src/Example/Infrastructure/Adapter/ClickhouseLogger.php)

### Преимущества подхода

1. **Тестируемость**: Конфигурационные значения могут быть легко заменены в тестах.
2. **Гибкость**: Возможность переопределения конфигурации через файлы конфигурации.
3. **Читаемость**: Явное указание зависимостей от конфигурации.
4. **Соответствие принципам Clean Architecture**: Конфигурация инкапсулирована в Presentation слое.

### Переменные окружения в .env файле

Все переменные окружения должны быть определены в файле `.env.example` с примерами значений и комментариями:

```env
# API Configuration
API_KEY=your_api_key_here
```
