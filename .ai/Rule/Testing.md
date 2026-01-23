# Тестирование

**Особенности написания тестов**:
- Методы в тестах должны начинаться со слова test, аннотация "@test" - не работает
- Класс с тестами должен наследоваться от Tests\TestCase, а не PHPUnit\Framework\TestCase
- Контроллеры надо тестировать только через E2E тесты
- Для контроллеров, возвращающих View, проверять содержимое шаблона (render())
- Для тестирования UseCase применяй Integration тесты, в конструктре могут быть зависимости `final class`
- Не использовать Mockery
- Вместо `app()` использовать `$this->service`.
  Пример: app(ValidationFactoryInterface::class) -> $this->service(ValidationFactoryInterface::class)
- Для Integration и E2E надо создавать записи в БД используя классы в папке [ModelFactory](../../backend/tests/Stub/ModelFactory)

**Когда писать тесты**:
- ✅ Все компоненты Application и Domain слоев **ОБЯЗАТЕЛЬНО** должны быть протестированы
- ❌ Тесты для конфигурации и простых DTO **НЕ НУЖНО** создавать (если они не содержат логики)
- ✅ Infrastructure слой (Repository, Adapter) должен быть протестирован (Integration тесты с БД)
- ✅ Presentation слой (Command, Listener) должен быть протестирован (E2E тесты)

**Минимальное требование**:
- Для каждого public метода — хотя бы один позитивный тест
- Для методов с валидацией — тесты на invalid данные
- Для методов с зависимостями — используются Mock/Stub объекты

## Типы тестов

Структура файлов с тестами должна повторять структуру модуля. 
Разделение по типу тестов только логическое.

### Unit тесты

Тестирование отдельных компонентов в изоляции (без зависимостей).

- **Расположение**: `backend/tests/Suite/{ModuleName}/Application`, `backend/tests/Suite/{ModuleName}/Domain`
- **Охватывает**:
  - Бизнес-логика в Service
  - Валидация в Validation классах
  - Логика в Domain объектах и ValueObject

### Integration тесты

Тестирование отдельных компонентов при взаимодействии с БД.

- **Расположение**: `backend/tests/Suite/{ModuleName}/Application/UseCase`, `backend/tests/Suite/{ModuleName}/Application/Query`, `backend/tests/Suite/{ModuleName}/Application/Command`
- **Охватывает**:
  - Бизнес-логика в UseCase, Query, Command

Тестирование взаимодействия компонентов с внешними системами.

- **Расположение**: `backend/tests/Suite/{ModuleName}/Infrastructure`
- **Охватывает**:
  - Adapter (взаимодействие с внешними сервисами)
  - Anti-corruption layer между модулями

### End-To-End (E2E) тесты

Тестирование полного потока: от HTTP запроса до ответа, включая все слои.

- **Расположение**: `backend/tests/Suite/{ModuleName}/Presentation`
- **Охватывает**:
  - HTTP контроллеры и маршруты
  - Middleware
  - Полный жизненный цикл запроса и данных

## Инструменты и утилиты

- **PHP_CodeSniffer**: Проверка единого стиля написания кода и соблюдения стандартов кодирования
- **PHPStan**: Статический анализ кода и проверка типов
- **Rector**: Автоматическая рефакторизация и модернизация кода
- **PostgreSQL**: Используется для тестовой БД с миграциями

## Примеры-шаблоны файлов модуля

### Application

- Unit тест для Service - [`ExampleCalcServiceTest.php`](../../backend/tests/Suite/Example/Application/ExampleCalcServiceTest.php)
- Integration тест для Command - [`ExampleOutboxCommandTest.php`](../../backend/tests/Suite/Example/Application/ExampleOutboxCommandTest.php)
- Unit тест для Responder - [`ExampleReportResponderTest.php`](../../backend/tests/Suite/Example/Application/ExampleReportResponderTest.php)
- Unit тест для Factory - [`ExampleRequestFactoryTest.php`](../../backend/tests/Suite/Example/Application/ExampleRequestFactoryTest.php)
- Integration тест для UseCase - [`ExampleUseCaseTest.php`](../../backend/tests/Suite/Example/Application/ExampleUseCaseTest.php)
- Integration тест для Query - [`GetExampleQueryTest.php`](../../backend/tests/Suite/Example/Application/GetExampleQueryTest.php)

### Domain

- Unit тест для исключения - [`ExampleNotFoundExceptionTest.php`](../../backend/tests/Suite/Example/Domain/ExampleNotFoundExceptionTest.php)
- Unit тест для ValueObject с валидацией - [`SubtractNumbersVOTest.php`](../../backend/tests/Suite/Example/Domain/SubtractNumbersVOTest.php)

### Infrastructure

- Integration тест для адаптера - [`ClickhouseLoggerTest.php`](../../backend/tests/Suite/Example/Infrastructure/ClickhouseLoggerTest.php)
- Integration тест для репозитория - [`EloquentExampleRepositoryTest.php`](../../backend/tests/Suite/Example/Infrastructure/EloquentExampleRepositoryTest.php)

### Presentation

- E2E тест для контроллера - [`ExampleControllerTest.php`](../../backend/tests/Suite/Example/Presentation/ExampleControllerTest.php)
- E2E тест для слушателя события - [`ExampleCreatedListenerTest.php`](../../backend/tests/Suite/Example/Presentation/ExampleCreatedListenerTest.php)
- E2E тест для middleware - [`ExampleMiddlewareTest.php`](../../backend/tests/Suite/Example/Presentation/ExampleMiddlewareTest.php)
- E2E тест для консольной команды - [`SubtractExampleCommandTest.php`](../../backend/tests/Suite/Example/Presentation/SubtractExampleCommandTest.php)
