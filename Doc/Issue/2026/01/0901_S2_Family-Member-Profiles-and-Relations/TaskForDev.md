# Технический план реализации: Профили членов семьи и связи

## Архитектурные решения

Реализация будет сосредоточена в новом модуле `Family`.

- **Domain**: Сущности `FamilyMember`, `Relationship`, Value Objects `FullName`, `LifePeriod`. Интерфейсы репозиториев.
- **Application**: UseCases для CRUD операций и управления связями. Команды и Запросы.
- **Infrastructure**: Репозитории на базе Eloquent, маппинг доменных сущностей на таблицы `gen_*`.
- **Presentation**: REST API контроллеры, Request/Response DTO.

## Модель предметной области

### Сущности (Entities)
- `FamilyMember`: ID (Integer), Gender, BirthDate, DeathDate, etc.
- `Relationship`: ID (Integer), PersonId, RelativeId, Type (Parent, Child, Spouse).

### Value Objects
- `FullName`: FirstName, LastName, MiddleName.
- `LifePeriod`: BirthDate, DeathDate (с валидацией: death >= birth).

### Интерфейсы
- `FamilyMemberRepositoryInterface`
- `RelationshipRepositoryInterface`

## Сценарии интеграции
- Модуль `Family` использует `Core` для базовых классов.
- Модуль `Family` требует аутентификации (через Middleware).

## Изменяемые файлы

### Domain
- `backend/src/Family/Domain/Entity/FamilyMember.php`
- `backend/src/Family/Domain/Entity/Relationship.php`
- `backend/src/Family/Domain/ValueObject/FullName.php`
- `backend/src/Family/Domain/ValueObject/LifePeriod.php`
- `backend/src/Family/Domain/FamilyMemberRepositoryInterface.php`
- `backend/src/Family/Domain/RelationshipRepositoryInterface.php`
- `backend/src/Family/Domain/Exception/CyclicRelationshipException.php`
- `backend/src/Family/Domain/Exception/InvalidLifePeriodException.php`

### Application
- `backend/src/Family/Application/UseCase/CreateFamilyMember.php`
- `backend/src/Family/Application/UseCase/UpdateFamilyMember.php`
- `backend/src/Family/Application/UseCase/DeleteFamilyMember.php`
- `backend/src/Family/Application/UseCase/GetFamilyMember.php`
- `backend/src/Family/Application/UseCase/ListFamilyMembers.php`
- `backend/src/Family/Application/UseCase/AddRelationship.php`
- `backend/src/Family/Application/UseCase/RemoveRelationship.php`
- `backend/src/Family/Application/Dto/FamilyMemberDto.php`

### Infrastructure
- `backend/src/Family/Infrastructure/Repository/EloquentFamilyMemberRepository.php`
- `backend/src/Family/Infrastructure/Repository/EloquentRelationshipRepository.php`

### Presentation
- `backend/src/Family/Presentation/Http/Controller/FamilyMemberController.php`
- `backend/src/Family/Presentation/Http/Controller/RelationshipController.php`
- `backend/src/Family/Presentation/Config/FamilyServiceProvider.php`
- `backend/src/Family/Domain/Request/CreateFamilyMemberRequest.php`
- `backend/src/Family/Domain/Response/FamilyMemberResponse.php`

## Последовательность действий

1. **Шаг 1: Подготовка инфраструктуры БД**
   - Создать миграции для добавления недостающих полей в таблицы:
     - Добавить поля `gender`, `birth_place`, `death_place`, `created_at`, `updated_at` в таблицу `gen_person`
     - Добавить поле `INFO` в таблицу `gen_person_info_lang` для хранения биографии
     - Добавить поле `metadata` в таблицу `gen_relation`

2. **Шаг 2: Domain слой**
   - Создать Value Objects `FullName` и `LifePeriod`.
   - Создать сущности `FamilyMember` и `Relationship`.
   - Определить интерфейсы репозиториев.

3. **Шаг 3: Infrastructure слой (База данных)**
   - Реализовать `EloquentFamilyMemberRepository`. 
   - Маппинг полей на таблицы `gen_person` и связанные таблицы.
   - Реализовать `EloquentRelationshipRepository`.

4. **Шаг 4: Application слой**
   - Реализовать UseCases для CRUD профилей.
   - Реализовать `AddRelationship` с бизнес-валидацией:
     - Проверка на циклы (рекурсивный поиск предков).
     - Проверка возраста (родитель старше ребенка).
     - Автоматическое создание обратной связи (если требуется логикой БД).

5. **Шаг 5: Presentation слой**
   - Создать контроллеры и зарегистрировать маршруты.
   - Настроить `FamilyServiceProvider` и зарегистрировать его в `bootstrap/providers.php`.

## Диаграмма потока данных (псевдокод)
```text
Client -> Controller -> RequestDTO -> UseCase -> DomainEntity -> Repository -> DB
```

## Миграции и конфигурация
Необходимо создать миграции для добавления недостающих полей в существующие таблицы:
- Добавление полей `gender`, `birth_place`, `death_place`, `created_at`, `updated_at` в таблицу `gen_person`
- Добавление поля `INFO` в таблицу `gen_person_info_lang`
- Добавление поля `metadata` в таблицу `gen_relation`

## Риски и альтернативы
- **Риск**: Сложность маппинга на старую схему БД (много таблиц для одного профиля).
- **Решение**: Инкапсулировать логику маппинга внутри репозитория.

## Чек-лист архитектурного соответствия
- [x] Clean Architecture (слои разделены)
- [x] CQRS (разделение на Command/Query UseCases)
- [x] Модульный монолит (код в `src/Family`)
- [x] Domain-driven (бизнес-логика в Domain и Application)
