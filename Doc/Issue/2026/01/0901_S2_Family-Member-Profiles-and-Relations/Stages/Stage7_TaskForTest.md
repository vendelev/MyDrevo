# План тестирования: Этап 7 - Валидация связей

## Общие принципы тестирования
- **Unit тесты:** Тестирование отдельных классов (сущности, value objects, сервисы).
- **Integration тесты:** Тестирование взаимодействия между компонентами (репозитории, обработчики).
- **E2E тесты:** Тестирование API эндпоинтов.
- **Фреймворк:** PHPUnit для unit/integration, Laravel Dusk или HTTP тесты для E2E.
- **Покрытие:** Минимум 80% кода.

## Структура тестов
Тестовые файлы организованы в директории `backend/tests/Suite/Family/` согласно модульной структуре:
- **Domain:** Unit тесты для доменных сервисов, сущностей и исключений (`backend/tests/Suite/Family/Domain/`).
- **Application:** Integration тесты для команд и запросов (`backend/tests/Suite/Family/Application/`).
- **Functional:** Тесты контроллеров и маршрутов (`backend/tests/Suite/Family/Functional/`).
- **E2E:** Полноценные тесты API (`backend/tests/Suite/Family/E2E/`).
- **Stub:** Фикстуры и тестовые данные (`backend/tests/Stub/Family/`).

## Тесты
### Unit тесты
- Тесты сервиса `RelationshipValidator` на обнаружение циклов в графах связей.
- Тесты исключений: `CyclicRelationshipException`, `DuplicateRelationshipException`, `InvalidAgeRelationshipException`.
- Тесты DTO `RelationshipValidationRequest` на корректность данных.

### Integration тесты
- Тесты обработчиков команд `CreateRelationshipCommandHandler` и `UpdateRelationshipCommandHandler` на вызов валидации и обработку исключений.
- Тесты взаимодействия с репозиториями `FamilyMemberRepository` и `RelationshipRepository` для получения данных валидации.

### E2E тесты
- Тесты API эндпоинтов для создания и обновления связей на возврат ошибок валидации в JSON формате.

## Сценарии
### Сценарий 1: Попытка создания циклической связи
- **Дано:** Граф связей с существующими отношениями (родитель-ребенок).
- **Проверяемое:** Попытка добавить связь, которая создаст цикл (например, ребенок становится родителем своего родителя).
- **Ожидаемый результат:** Выбрасывается `CyclicRelationshipException`, связь не сохраняется.

### Сценарий 2: Дублирование связи
- **Дано:** Существующая связь между двумя членами семьи.
- **Проверяемое:** Попытка создать идентичную связь (тот же тип отношения).
- **Ожидаемый результат:** Выбрасывается `DuplicateRelationshipException`, дубликат не сохраняется.

### Сценарий 3: Связь с логическими ошибками (ребенок старше родителя)
- **Дано:** Даты рождения членов семьи (родитель рожден раньше ребенка).
- **Проверяемое:** Попытка установить отношение родитель-ребенок, где даты противоречат логике (ребенок старше).
- **Ожидаемый результат:** Выбрасывается `InvalidAgeRelationshipException`, связь не сохраняется.

### Сценарий 4: Корректная связь
- **Дано:** Валидные данные для новой связи без циклов, дублей и логических ошибок.
- **Проверяемое:** Создание связи через API или команду.
- **Ожидаемый результат:** Связь успешно сохраняется, возвращается успешный ответ.

## Изменяемые файлы
- `backend/tests/Suite/Family/Domain/RelationshipValidatorTest.php` (Unit тесты валидатора)
- `backend/tests/Suite/Family/Domain/CyclicRelationshipExceptionTest.php` (Unit тесты исключений)
- `backend/tests/Suite/Family/Domain/DuplicateRelationshipExceptionTest.php`
- `backend/tests/Suite/Family/Domain/InvalidAgeRelationshipExceptionTest.php`
- `backend/tests/Suite/Family/Domain/RelationshipValidationRequestTest.php` (Unit тесты DTO)
- `backend/tests/Suite/Family/Application/CreateRelationshipCommandHandlerTest.php` (Integration тесты обработчиков)
- `backend/tests/Suite/Family/Application/UpdateRelationshipCommandHandlerTest.php`
- `backend/tests/Suite/Family/Functional/CreateRelationshipControllerTest.php` (Functional тесты контроллеров)
- `backend/tests/Suite/Family/Functional/UpdateRelationshipControllerTest.php`
- `backend/tests/Suite/Family/E2E/RelationshipValidationApiTest.php` (E2E тесты API)
- `backend/tests/Stub/Family/FamilyMemberFactory.php` (Фабрики для тестовых данных)
- `backend/tests/Stub/Family/RelationshipFactory.php`

## Общие рекомендации
- Использовать фабрики для тестовых данных.
- Тестировать исключения и edge cases.
- Запускать тесты после каждого этапа.
- Интеграция с CI/CD для автоматического тестирования.
- Команды запуска: `vendor/bin/phpunit --testsuite Family` для модульных тестов, `make php-run CMD="php artisan test --testsuite=Family"` для всех.
