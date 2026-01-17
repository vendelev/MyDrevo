# План тестирования: Этап 3 - CRUD API для профилей

## Общие принципы тестирования
- **Unit тесты:** Тестирование отдельных классов (сущности, value objects, сервисы).
- **Integration тесты:** Тестирование взаимодействия между компонентами (репозитории, обработчики).
- **E2E тесты:** Тестирование API эндпоинтов.
- **Фреймворк:** PHPUnit для unit/integration, Laravel HTTP тесты для E2E.
- **Покрытие:** Минимум 80% кода.

## Структура тестов
Тестовые файлы организованы в директории `backend/tests/Suite/Family/` согласно архитектуре модуля:
- `backend/tests/Suite/Family/Application/` - Тесты Use Cases, команд и запросов.
- `backend/tests/Suite/Family/Domain/` - Тесты доменных объектов (сущности, value objects).
- `backend/tests/Suite/Family/Presentation/` - Тесты контроллеров и HTTP слоя.
- `backend/tests/Suite/Family/Integration/` - Тесты взаимодействия между компонентами.
- `backend/tests/Suite/Family/E2E/` - Полноценные тесты API эндпоинтов.

## Тесты
### Unit тесты
- **Тесты команд и запросов на корректность данных:**
  - `CreateFamilyMemberCommandTest`: Валидация обязательных полей (firstName, lastName), типов данных (birthDate как DateTime), ограничений (длина строк).
  - `UpdateFamilyMemberCommandTest`: Проверка наличия ID, валидация обновляемых полей, обработка частичных обновлений.
  - `DeleteFamilyMemberCommandTest`: Валидация ID, проверка существования профиля.
  - `GetFamilyMemberQueryTest`: Валидация ID, проверка формата запроса.
  - `ListFamilyMembersQueryTest`: Валидация параметров фильтрации (имя, фамилия), пагинации.
- **Тесты DTO:**
  - `FamilyMemberDtoTest`: Проверка сериализации/десериализации данных, валидация полей.
  - `CreateFamilyMemberDtoTest`: Валидация входных данных при создании.
  - `UpdateFamilyMemberDtoTest`: Валидация входных данных при обновлении.

### Integration тесты
- **Тесты обработчиков команд/запросов:**
  - `CreateFamilyMemberUseCaseTest`: Сохранение профиля в БД, возврат корректного DTO, обработка ошибок валидации.
  - `UpdateFamilyMemberUseCaseTest`: Обновление существующего профиля, проверка прав доступа (userId), возврат обновленного DTO.
  - `DeleteFamilyMemberUseCaseTest`: Удаление профиля, проверка зависимостей (семейные связи), обработка несуществующего ID.
  - `GetFamilyMemberUseCaseTest`: Получение одного профиля по ID, проверка прав доступа, обработка несуществующего профиля.
  - `ListFamilyMembersUseCaseTest`: Получение списка профилей с фильтрацией, пагинацией, проверка прав доступа.
- **Тесты репозиториев:**
  - `FamilyMemberRepositoryTest`: Взаимодействие с БД, CRUD операции, обработка исключений БД.

### E2E тесты
- **Тесты API эндпоинтов:**
  - `POST /api/v1/family-members`: Создание профиля, проверка статуса 201, корректность ответа, сохранение в БД.
  - `GET /api/v1/family-members`: Получение списка профилей, проверка фильтрации, пагинации, статуса 200.
  - `GET /api/v1/family-members/{id}`: Получение одного профиля, проверка существования, прав доступа, статуса 200/404.
  - `PUT /api/v1/family-members/{id}`: Обновление профиля, проверка валидации, прав доступа, статуса 200.
  - `DELETE /api/v1/family-members/{id}`: Удаление профиля, проверка существования, зависимостей, статуса 204.

## Сценарии
1. **Создание профиля через API:** Успешное создание с валидными данными, возврат 201 и DTO.
2. **Создание профиля с невалидными данными:** Возврат 422 с ошибками валидации.
3. **Получение списка профилей:** Фильтрация по имени, пагинация, возврат 200 с массивом DTO.
4. **Получение несуществующего профиля:** Возврат 404.
5. **Обновление профиля:** Успешное обновление, возврат 200 с обновленным DTO.
6. **Обновление чужого профиля:** Возврат 403 (запрещено).
7. **Удаление профиля:** Успешное удаление, возврат 204.
8. **Удаление профиля с зависимостями:** Возврат 409 (конфликт) или каскадное удаление связей.

## Изменяемые файлы
- `backend/tests/Suite/Family/Application/CreateFamilyMemberUseCaseTest.php`
- `backend/tests/Suite/Family/Application/UpdateFamilyMemberUseCaseTest.php`
- `backend/tests/Suite/Family/Application/DeleteFamilyMemberUseCaseTest.php`
- `backend/tests/Suite/Family/Application/GetFamilyMemberUseCaseTest.php`
- `backend/tests/Suite/Family/Application/ListFamilyMembersUseCaseTest.php`
- `backend/tests/Suite/Family/Application/CreateFamilyMemberCommandTest.php`
- `backend/tests/Suite/Family/Application/UpdateFamilyMemberCommandTest.php`
- `backend/tests/Suite/Family/Application/DeleteFamilyMemberCommandTest.php`
- `backend/tests/Suite/Family/Application/GetFamilyMemberQueryTest.php`
- `backend/tests/Suite/Family/Application/ListFamilyMembersQueryTest.php`
- `backend/tests/Suite/Family/Application/FamilyMemberDtoTest.php`
- `backend/tests/Suite/Family/Application/CreateFamilyMemberDtoTest.php`
- `backend/tests/Suite/Family/Application/UpdateFamilyMemberDtoTest.php`
- `backend/tests/Suite/Family/Integration/FamilyMemberRepositoryTest.php`
- `backend/tests/Suite/Family/Presentation/FamilyMemberControllerTest.php`
- `backend/tests/Suite/Family/E2E/FamilyMemberApiTest.php`

## Общие рекомендации
- Использовать фабрики для тестовых данных (Laravel Factories для моделей).
- Тестировать исключения и edge cases (пустые поля, слишком длинные строки, даты в будущем).
- Запускать тесты после каждого этапа: `make php-run CMD="php artisan test --testsuite=Family"`.
- Интеграция с CI/CD для автоматического тестирования.
- Использовать мокинг для внешних зависимостей (репозитории в unit тестах).
- Проверять покрытие: `make php-run CMD="php artisan test --coverage"`.
