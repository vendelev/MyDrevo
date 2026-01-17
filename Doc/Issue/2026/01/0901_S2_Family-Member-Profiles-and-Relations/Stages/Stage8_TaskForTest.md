# План тестирования: Этап 8 - Поиск и фильтрация

## Общие принципы тестирования
- **Unit тесты:** Тестирование отдельных классов (сущности, value objects, сервисы).
- **Integration тесты:** Тестирование взаимодействия между компонентами (репозитории, обработчики).
- **E2E тесты:** Тестирование API эндпоинтов.
- **Фреймворк:** PHPUnit для unit/integration, Laravel Dusk или HTTP тесты для E2E.
- **Покрытие:** Минимум 80% кода.

## Структура тестов
Тесты организованы в директории `backend/tests/Suite/Family/` с поддиректориями:
- `Application/` — Тесты для команд, запросов и use cases.
- `Domain/` — Тесты для сущностей, value objects и доменной логики.
- `E2E/` — Сквозные тесты API эндпоинтов.
- `Functional/` — Тесты контроллеров и HTTP слоя.
- `Integration/` — Тесты взаимодействия с базой данных и репозиториями.
- `Presentation/` — Тесты представлений и маршрутов.

## Тесты
- **Unit:**
  - Тесты для DTO `FamilyMemberSearchRequest` — валидация параметров поиска (имя, фамилия, пол).
  - Тесты для Query `GetFamilyMembersQuery` — обработка параметров поиска и передача в репозиторий.
  - Тесты для UseCase `ListFamilyMembers` — применение логики поиска и возврат результатов.
  - Тесты для Value Object `SearchCriteria` — нормализация и валидация критериев поиска.
- **Integration:**
  - Тесты для `FamilyMemberRepository` — фильтрация данных с использованием Eloquent scopes по имени, фамилии и другим полям.
  - Тесты взаимодействия репозитория с базой данных SQLite.
- **E2E:**
  - Тесты API эндпоинта `GET /api/v1/family-members` с параметрами поиска (query params: name, surname, gender).
  - Тесты пагинации результатов поиска.

## Сценарии
1. **Поиск по имени.**
   - **Дано:** Существует член семьи с именем "Иван".
   - **Проверяемое:** Выполнение поиска с параметром `name=Иван`.
   - **Ожидаемый результат:** Возвращается список, содержащий данного члена семьи.
2. **Поиск по фамилии.**
   - **Дано:** Существует член семьи с фамилией "Иванов".
   - **Проверяемое:** Выполнение поиска с параметром `surname=Иванов`.
   - **Ожидаемый результат:** Возвращается список, содержащий данного члена семьи.
3. **Фильтрация по полу.**
   - **Дано:** Существуют члены семьи мужского и женского пола.
   - **Проверяемое:** Выполнение поиска с параметром `gender=male`.
   - **Ожидаемый результат:** Возвращается список только мужских членов семьи.
4. **Комбинированный поиск.**
   - **Дано:** Существует член семьи с именем "Иван" и фамилией "Иванов".
   - **Проверяемое:** Выполнение поиска с параметрами `name=Иван&surname=Иванов`.
   - **Ожидаемый результат:** Возвращается список, содержащий данного члена семьи.
5. **Поиск без результатов.**
   - **Дано:** Нет членов семьи с указанным именем.
   - **Проверяемое:** Выполнение поиска с параметром `name=Несуществующее`.
   - **Ожидаемый результат:** Возвращается пустой список.
6. **Пагинация результатов.**
   - **Дано:** Существует более 10 членов семьи.
   - **Проверяемое:** Выполнение поиска без параметров с лимитом 5.
   - **Ожидаемый результат:** Возвращается первые 5 результатов с информацией о пагинации.

## Изменяемые файлы
- `backend/tests/Suite/Family/Application/DTO/FamilyMemberSearchRequestTest.php` (новый) — Unit тесты для DTO.
- `backend/tests/Suite/Family/Application/Query/GetFamilyMembersQueryTest.php` (обновление) — Unit тесты для Query.
- `backend/tests/Suite/Family/Application/UseCase/ListFamilyMembersTest.php` (обновление) — Unit тесты для UseCase.
- `backend/tests/Suite/Family/Domain/ValueObject/SearchCriteriaTest.php` (новый) — Unit тесты для Value Object.
- `backend/tests/Suite/Family/Integration/Repository/FamilyMemberRepositoryTest.php` (обновление) — Integration тесты для репозитория.
- `backend/tests/Suite/Family/E2E/FamilyMemberSearchApiTest.php` (новый) — E2E тесты для API поиска.
- `backend/tests/Suite/Family/Functional/FamilyMemberControllerSearchTest.php` (обновление) — Functional тесты для контроллера.

## Общие рекомендации
- Использовать фабрики для тестовых данных (Laravel factories для моделей).
- Тестировать исключения и edge cases (пустые параметры, некорректные значения).
- Запускать тесты после каждого этапа с помощью `vendor/bin/phpunit --testsuite=Family`.
- Интеграция с CI/CD для автоматического тестирования.
- Чек-лист выполнения:
  - [ ] Запустить unit тесты: `make php-run CMD="vendor/bin/phpunit --testsuite=Family --group=unit"`
  - [ ] Запустить integration тесты: `make php-run CMD="vendor/bin/phpunit --testsuite=Family --group=integration"`
  - [ ] Запустить E2E тесты: `make php-run CMD="vendor/bin/phpunit --testsuite=Family --group=e2e"`
  - [ ] Проверить покрытие: `make php-run CMD="vendor/bin/phpunit --coverage-html=reports/coverage"`
