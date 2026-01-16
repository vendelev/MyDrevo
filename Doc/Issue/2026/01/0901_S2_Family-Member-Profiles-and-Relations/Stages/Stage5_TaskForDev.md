# Технический план реализации: Этап 5 - Реализация модели Relationship

## Общие архитектурные принципы
- **Clean Architecture:** Разделение на слои (Domain, Application, Infrastructure, Presentation).
- **CQRS:** Разделение команд (изменения состояния) и запросов (чтение данных).
- **Модульный монолит:** Функциональность организована в модули (FamilyMember, Relationship).
- **Laravel:** Использование фреймворка для инфраструктуры (миграции, роутинг, DI).

## Структура модулей
- **FamilyMember Module:** Управление профилями членов семьи.
- **Relationship Module:** Управление семейными связями.
- **Core Module:** Общие интерфейсы, базовые классы CQRS.

## Архитектурные решения
- Сущность `Relationship` как агрегат.
- Enum для типов связей.
- Репозиторий аналогично FamilyMember.

## Последовательность действий
1. Создать namespace `App\Modules\Relationship\Domain`.
2. Определить enum `RelationshipType` (parent, child, spouse).
3. Создать Entity `Relationship` с personId, relativeId, type, metadata.
4. Создать интерфейс `RelationshipRepository`.
5. Реализовать `EloquentRelationshipRepository`.

## Модели предметной области
- `Relationship`: Агрегат с ID, ссылками на FamilyMember, типом и метаданными.

## Изменяемые файлы
- `backend/src/Family/Domain/Entity/Relationship.php`
- `backend/src/Family/Domain/RelationshipRepositoryInterface.php`
- `backend/src/Family/Infrastructure/Repository/EloquentRelationshipRepository.php`

## Общие рекомендации
- Каждый этап тестировать unit и integration тестами.
- Следовать PSR-4 для автозагрузки.
- Использовать Laravel's service container для DI.
- Документировать код PHPDoc.