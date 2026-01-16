# Технический план реализации: Этап 6 - API для связей

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
- Команды для создания/удаления связей.
- Логика обратных связей в обработчиках.

## Последовательность действий
1. Создать команды: `CreateRelationshipCommand`, `DeleteRelationshipCommand`.
2. Реализовать обработчики с логикой создания обратных связей (например, при parent автоматически child).
3. Создать контроллер `RelationshipController`.
4. Настроить роутинг.

## Модели предметной области
- Команды с логикой связей.

## Изменяемые файлы
- `backend/src/Family/Application/UseCase/AddRelationship.php`
- `backend/src/Family/Application/UseCase/RemoveRelationship.php`
- `backend/src/Family/Presentation/Http/Controller/RelationshipController.php`

## Общие рекомендации
- Каждый этап тестировать unit и integration тестами.
- Следовать PSR-4 для автозагрузки.
- Использовать Laravel's service container для DI.
- Документировать код PHPDoc.