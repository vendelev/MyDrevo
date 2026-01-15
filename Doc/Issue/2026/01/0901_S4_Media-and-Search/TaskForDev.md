# Технический план реализации: Медиа и поиск (Этап 4)

## Архитектурное описание

- **Domain**: Сущности `Media`, `SearchQuery`, Value Objects `SearchCriteria`. Интерфейсы репозиториев.
- **Application**: UseCases для загрузки/удаления медиа, поиска персон. Команды и Запросы.
- **Infrastructure**: Репозитории на базе Eloquent, маппинг доменных сущностей на таблицы `gen_*`, интеграция с файловым хранилищем.
- **Presentation**: REST API контроллеры, Request/Response DTO.

### Сущности (Entities)
- `Media`: ID (Integer), FileName, FileType, FileSize, FilePath, PreviewPath, Description, UploadedAt, OwnerId, IsPublic.
- `SearchQuery`: ID (Integer), Criteria (SearchCriteria), UserId, ExecutedAt.

### Value Objects
- `SearchCriteria`: FullName (String), BirthYearFrom (Integer), BirthYearTo (Integer), BirthPlace (String), Gender (Gender), IsAlive (Boolean).

## Технические требования

### Backend (Laravel)
1.  **Модуль `Media`:**
    - Расположение: `src/Media`.
    - Зависит от: `src/Family`.
2.  **Domain слой:**
    - `src/Media/Domain/Entity/Media.php`.
    - `src/Media/Domain/ValueObject/SearchCriteria.php`.
    - `src/Media/Domain/Repository/MediaRepositoryInterface.php`.
    - `src/Media/Domain/Repository/SearchRepositoryInterface.php`.
3.  **Application слой:**
    - `src/Media/Application/UseCase/UploadMediaUseCase.php`.
    - `src/Media/Application/UseCase/DeleteMediaUseCase.php`.
    - `src/Media/Application/UseCase/SearchFamilyMembersUseCase.php`.
    - `src/Media/Application/Service/FileStorageService.php`.
    - `src/Media/Application/Service/PreviewGeneratorService.php`.
4.  **Infrastructure слой:**
    - `src/Media/Infrastructure/Repository/EloquentMediaRepository.php`.
    - `src/Media/Infrastructure/Repository/EloquentSearchRepository.php`.
    - `src/Media/Infrastructure/Storage/LocalStorageAdapter.php`.
    - `src/Media/Infrastructure/Storage/S3StorageAdapter.php`.
5.  **Presentation слой:**
    - `src/Media/Presentation/Http/Controller/MediaController.php`.
    - `src/Media/Presentation/Http/Controller/SearchController.php`.
    - `src/Media/Presentation/Http/Request/UploadMediaRequest.php`.
    - `src/Media/Presentation/Http/Request/SearchRequest.php`.
    - `src/Media/Presentation/Http/Response/MediaResponse.php`.
    - `src/Media/Presentation/Http/Response/SearchResponse.php`.

### Frontend (React/Vue)
1.  **Компоненты:**
    - `MediaGallery.vue` — галерея медиафайлов.
    - `MediaUpload.vue` — форма загрузки.
    - `SearchForm.vue` — форма поиска.
    - `SearchResults.vue` — список результатов поиска.
2.  **Сервисы:**
    - `MediaApiService.js` — обертка над HTTP-запросами к медиа API.
    - `SearchApiService.js` — обертка над HTTP-запросами к поисковому API.

## План разработки

### Подготовка
1.  **Шаг 1: Подготовка модуля**
    - Создать директорию `src/Media`.
    - Определить зависимости от `src/Family`.

### Domain
2.  **Шаг 2: Domain слой**
    - Создать сущность `Media`.
    - Создать Value Object `SearchCriteria`.
    - Определить интерфейсы `MediaRepositoryInterface` и `SearchRepositoryInterface`.

### Application
3.  **Шаг 3: Application слой**
    - Реализовать UseCases: `UploadMediaUseCase`, `DeleteMediaUseCase`, `SearchFamilyMembersUseCase`.
    - Создать сервисы: `FileStorageService`, `PreviewGeneratorService`.

### Infrastructure
4.  **Шаг 4: Infrastructure слой**
    - Реализовать `EloquentMediaRepository` и `EloquentSearchRepository`.
    - Создать адаптеры для файлового хранилища: `LocalStorageAdapter`, `S3StorageAdapter`.

### Presentation
5.  **Шаг 5: Presentation слой**
    - Создать контроллеры `MediaController` и `SearchController`.
    - Реализовать Request/Response DTO.
    - Добавить маршруты в `routes/api.php`.

### Frontend
6.  **Шаг 6: Frontend реализация**
    - Создать компоненты для галереи, загрузки и поиска.
    - Реализовать взаимодействие с Backend API.

## Чек-лист архитектурного соответствия
- [x] Clean Architecture (слои разделены)
- [x] CQRS (разделение на Command/Query UseCases)
- [x] Модульный монолит (код в `src/Media`)
- [x] Domain-driven (бизнес-логика в Domain и Application)
