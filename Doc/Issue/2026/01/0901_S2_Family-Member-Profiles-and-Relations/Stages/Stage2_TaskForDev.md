# Технический план реализации: Этап 2 - Реализация модели FamilyMember

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
- Сущность `FamilyMember` в Domain слое.
- Value Objects для неизменяемых данных.
- Репозиторий интерфейс в Domain, реализация в Infrastructure.

## Последовательность действий
1. Создать namespace `App\Modules\FamilyMember\Domain`.
2. Определить enum `Gender`.
3. Создать Value Object `FullName` (firstName, lastName, middleName).
4. Создать Value Object `LifePeriod` (birthDate, deathDate) с методами валидации.
5. Создать Entity `FamilyMember` с методами для обновления данных.
6. Создать интерфейс `FamilyMemberRepository` в Domain.
7. Реализовать `EloquentFamilyMemberRepository` в Infrastructure.

## Модели предметной области
- `FamilyMember`: Агрегат с ID, FullName, Gender, LifePeriod, biography, userId, timestamps.
- Репозиторий для сохранения и извлечения.

## Изменяемые файлы
- `backend/src/Family/Domain/Entity/FamilyMember.php`
- `backend/src/Family/Domain/ValueObject/FullName.php`
- `backend/src/Family/Domain/ValueObject/LifePeriod.php`
- `backend/src/Family/Domain/FamilyMemberRepositoryInterface.php`
- `backend/src/Family/Domain/Exception/InvalidLifePeriodException.php`
- `backend/src/Family/Infrastructure/Repository/EloquentFamilyMemberRepository.php`

## Общие рекомендации
- Каждый этап тестировать unit и integration тестами.
- Следовать PSR-4 для автозагрузки.
- Использовать Laravel's service container для DI.
- Документировать код PHPDoc.