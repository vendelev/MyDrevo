# Технический план реализации: Этап 3 - CRUD API для профилей

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
- Команды для создания/обновления/удаления.
- Запросы для чтения.
- DTO для передачи данных между слоями.
- Контроллеры в Presentation слое.

## Последовательность действий
1. Создать команды: `CreateFamilyMemberCommand`, `UpdateFamilyMemberCommand`, `DeleteFamilyMemberCommand`.
2. Создать запросы: `GetFamilyMembersQuery`, `GetFamilyMemberQuery`.
3. Создать DTO: `FamilyMemberDto`, `CreateFamilyMemberDto`.
4. Реализовать обработчики команд и запросов в Application слое.
5. Создать контроллер `FamilyMemberController` с эндпоинтами.
6. Настроить роутинг в Laravel.

## Модели предметной области
- Команды и запросы как объекты с данными.
- Обработчики с бизнес-логикой.

## Изменяемые файлы
- `backend/src/Family/Application/UseCase/CreateFamilyMember.php`
- `backend/src/Family/Application/UseCase/UpdateFamilyMember.php`
- `backend/src/Family/Application/UseCase/DeleteFamilyMember.php`
- `backend/src/Family/Application/UseCase/GetFamilyMember.php`
- `backend/src/Family/Application/UseCase/ListFamilyMembers.php`
- `backend/src/Family/Application/Dto/FamilyMemberDto.php`
- `backend/src/Family/Presentation/Http/Controller/FamilyMemberController.php`
- `backend/src/Family/Domain/Request/CreateFamilyMemberRequest.php`
- `backend/src/Family/Domain/Response/FamilyMemberResponse.php`
- `backend/src/Family/Presentation/Config/FamilyServiceProvider.php`

## Общие рекомендации
- Каждый этап тестировать unit и integration тестами.
- Следовать PSR-4 для автозагрузки.
- Использовать Laravel's service container для DI.
- Документировать код PHPDoc.