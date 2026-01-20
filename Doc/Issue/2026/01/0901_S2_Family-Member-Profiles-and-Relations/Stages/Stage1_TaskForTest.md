# Этап 1. Создание структуры модуля FamilyMember с заглушками — план для тестирования

## Цель этапа

- Создать полную структуру тестовых файлов для модуля FamilyMember согласно Clean Architecture и CQRS.
- Реализовать все тестовые классы с `markTestSkipped` (заглушками для будущей реализации).
- Подготовить основу для тестирования функциональности CRUD профилей членов семьи и связей на последующих этапах.

## Общие принципы тестирования

- Типы тестов: Unit, Integration, E2E.
- Разделяй ответственность тестов:
  - Unit — доменные правила/DTO/валидации без внешних зависимостей.
  - Integration — связка команд/запросов/репозиториев с БД.
  - E2E — HTTP-флоу от роутинга до ответа.
- Каждый сценарий описывай в формате: **Дано → Проверяемое → Ожидаемый результат**.
- На этапе 1 все тесты используют `markTestSkipped` для пропуска выполнения, так как реализация — заглушки.

## Структура тестовых файлов

**ВАЖНО**. Для уменьшения контекста для каждого создания или изменения файла запускай нового агента в режиме "testing".

ModelFactory:

- `backend/tests/Stub/ModelFactory/FamilyMemberFactory.php` — фабрика для тестов
- `backend/tests/Stub/ModelFactory/RelationshipFactory.php` — фабрика для тестов

Unit:

- `backend/tests/Suite/FamilyMember/Domain/FamilyMemberTest.php` — Unit тесты для сущности FamilyMember (свойства, методы).
- `backend/tests/Suite/FamilyMember/Domain/RelationshipTest.php` — Unit тесты для сущности Relationship (свойства, методы).
- `backend/tests/Suite/FamilyMember/Domain/FullNameTest.php` — Unit тесты для VO FullName (валидация имени).
- `backend/tests/Suite/FamilyMember/Domain/LifePeriodTest.php` — Unit тесты для VO LifePeriod (валидация дат).
- `backend/tests/Suite/FamilyMember/Domain/FamilyMemberNotFoundExceptionTest.php` — Unit тесты для исключения FamilyMemberNotFoundException.
- `backend/tests/Suite/FamilyMember/Domain/RelationshipNotFoundExceptionTest.php` — Unit тесты для исключения RelationshipNotFoundException.
- `backend/tests/Suite/FamilyMember/Domain/InvalidRelationshipExceptionTest.php` — Unit тесты для исключения InvalidRelationshipException.

Integration:

- `backend/tests/Suite/FamilyMember/Application/CreateFamilyMemberUseCaseTest.php` — Integration тесты для UseCase создания члена семьи (связь с репозиторием).
- `backend/tests/Suite/FamilyMember/Application/GetFamilyMembersUseCaseTest.php` — Integration тесты для UseCase получения списка членов семьи.
- `backend/tests/Suite/FamilyMember/Application/UpdateFamilyMemberUseCaseTest.php` — Integration тесты для UseCase обновления члена семьи.
- `backend/tests/Suite/FamilyMember/Application/DeleteFamilyMemberUseCaseTest.php` — Integration тесты для UseCase удаления члена семьи.
- `backend/tests/Suite/FamilyMember/Application/CreateRelationshipUseCaseTest.php` — Integration тесты для UseCase создания связи.
- `backend/tests/Suite/FamilyMember/Application/DeleteRelationshipUseCaseTest.php` — Integration тесты для UseCase удаления связи.
- `backend/tests/Suite/FamilyMember/Application/CreateFamilyMemberCommandTest.php` — Integration тесты для Command создания члена семьи.
- `backend/tests/Suite/FamilyMember/Application/UpdateFamilyMemberCommandTest.php` — Integration тесты для Command обновления члена семьи.
- `backend/tests/Suite/FamilyMember/Application/DeleteFamilyMemberCommandTest.php` — Integration тесты для Command удаления члена семьи.
- `backend/tests/Suite/FamilyMember/Application/CreateRelationshipCommandTest.php` — Integration тесты для Command создания связи.
- `backend/tests/Suite/FamilyMember/Application/DeleteRelationshipCommandTest.php` — Integration тесты для Command удаления связи.
- `backend/tests/Suite/FamilyMember/Application/GetFamilyMembersQueryTest.php` — Integration тесты для Query получения списка членов семьи.
- `backend/tests/Suite/FamilyMember/Application/GetFamilyMemberByIdQueryTest.php` — Integration тесты для Query получения члена семьи по ID.
- `backend/tests/Suite/FamilyMember/Application/RelationshipValidationServiceTest.php` — Integration тесты для Service валидации связей.
- `backend/tests/Suite/FamilyMember/Infrastructure/EloquentFamilyMemberRepositoryTest.php` — Integration тесты для репозитория членов семьи (связь с БД).
- `backend/tests/Suite/FamilyMember/Infrastructure/EloquentRelationshipRepositoryTest.php` — Integration тесты для репозитория связей (связь с БД).

E2E:

- `backend/tests/Suite/FamilyMember/Presentation/FamilyMemberControllerTest.php` — E2E тесты для контроллера членов семьи (HTTP запросы/ответы).
- `backend/tests/Suite/FamilyMember/Presentation/RelationshipControllerTest.php` — E2E тесты для контроллера связей (HTTP запросы/ответы).

## Сценарии

1. Проверка запуска PHPUnot
   - Дано: Созданные тесты с методами заглушками.
   - Проверяемое: Надо выполнить запуск PHPUnit.
   - Ожидаемый результат: Все тесты проходят без ошибок.
