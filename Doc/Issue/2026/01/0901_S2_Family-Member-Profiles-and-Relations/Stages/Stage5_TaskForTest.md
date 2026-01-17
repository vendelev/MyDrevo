# План тестирования: Этап 5 - Реализация модели Relationship

## Общие принципы тестирования
- **Unit тесты:** Тестирование отдельных классов (сущности, value objects, сервисы).
- **Integration тесты:** Тестирование взаимодействия между компонентами (репозитории, обработчики).
- **E2E тесты:** Тестирование API эндпоинтов.
- **Фреймворк:** PHPUnit для unit/integration, Laravel Dusk или HTTP тесты для E2E.
- **Покрытие:** Минимум 80% кода.

## Тесты
- **Unit тесты:**
  - Тесты сущности Relationship: создание, валидация полей, методы equals, getters/setters.
  - Тесты RelationshipType enum: проверка значений, методы получения списка типов.
- **Integration тесты:**
  - Тесты репозитория связей: сохранение, загрузка по ID, загрузка по personId, удаление.
- **E2E тесты:**
  - Тесты API эндпоинтов: создание связи через POST, получение через GET, обновление через PUT, удаление через DELETE.

## Структура тестов
- Тесты организованы в директории `backend/tests/Suite/Family/` по слоям архитектуры.
- **Domain:** Unit тесты для сущностей и value objects (`RelationshipTest.php`, `RelationshipTypeTest.php`).
- **Infrastructure:** Integration тесты для репозиториев (`RelationshipRepositoryTest.php`).
- **Application:** Integration тесты для команд и запросов (`RelationshipCommandTest.php`, `RelationshipQueryTest.php`).
- **Presentation:** Functional тесты для контроллеров (`RelationshipControllerTest.php`).
- **E2E:** Полноценные тесты через HTTP (`RelationshipApiTest.php`).

## Сценарии
1. **Создание связи с валидными данными.**
   - Дано: Валидные personId (существующий FamilyMember), relativeId (существующий FamilyMember), type (RelationshipType::PARENT).
   - Проверяемое: Создание экземпляра Relationship entity.
   - Ожидаемый результат: Entity создана без исключений, все поля установлены правильно, metadata пустой массив.

2. **Создание связи с невалидными данными (несуществующий personId).**
   - Дано: Несуществующий personId, валидный relativeId, type.
   - Проверяемое: Попытка создания Relationship.
   - Ожидаемый результат: Исключение DomainException с сообщением о несуществующем FamilyMember.

3. **Сохранение и загрузка связи.**
   - Дано: Созданная Relationship entity.
   - Проверяемое: Сохранение через репозиторий, затем загрузка по ID.
   - Ожидаемый результат: Загруженная entity идентична сохраненной.

4. **Загрузка связей по personId.**
   - Дано: Несколько связей для одного personId.
   - Проверяемое: Вызов findByPersonId(personId).
   - Ожидаемый результат: Возвращена коллекция с правильными связями.

5. **Удаление связи.**
   - Дано: Существующая связь.
   - Проверяемое: Удаление через репозиторий, затем попытка загрузки.
   - Ожидаемый результат: Связь удалена, загрузка возвращает null или исключение.

6. **API создание связи (E2E).**
   - Дано: HTTP POST запрос с валидными данными.
   - Проверяемое: Отправка запроса на /api/relationships.
   - Ожидаемый результат: Статус 201, связь создана в БД.

7. **API получение связей (E2E).**
   - Дано: Существующие связи.
   - Проверяемое: HTTP GET запрос на /api/relationships/{personId}.
   - Ожидаемый результат: Статус 200, JSON с массивом связей.

## Изменяемые файлы
- `backend/tests/Suite/Family/Domain/RelationshipTest.php`
- `backend/tests/Suite/Family/Domain/RelationshipTypeTest.php`
- `backend/tests/Suite/Family/Infrastructure/RelationshipRepositoryTest.php`
- `backend/tests/Suite/Family/Application/RelationshipCommandTest.php`
- `backend/tests/Suite/Family/Application/RelationshipQueryTest.php`
- `backend/tests/Suite/Family/Presentation/RelationshipControllerTest.php`
- `backend/tests/Suite/Family/E2E/RelationshipApiTest.php`

## Общие рекомендации
- Использовать фабрики для тестовых данных.
- Тестировать исключения и edge cases.
- Запускать тесты после каждого этапа.
- Интеграция с CI/CD для автоматического тестирования.

## Критерии приемки
- Все требования из [Spec.md](../../Spec.md) выполнены.
- Модель Relationship полностью реализована и протестирована.
- API для управления связями работает корректно.

## Чек-лист выполнения
- [ ] Unit тесты проходят: `make php-run CMD="php artisan test backend/tests/Suite/Family/Domain/"`
- [ ] Integration тесты проходят: `make php-run CMD="php artisan test backend/tests/Suite/Family/Infrastructure/"`
- [ ] E2E тесты проходят: `make php-run CMD="php artisan test backend/tests/Suite/Family/E2E/"`
- [ ] Покрытие кода >= 80%: `make php-run CMD="php artisan test --coverage"`
- [ ] Ревью кода проведено, линтеры проходят.
