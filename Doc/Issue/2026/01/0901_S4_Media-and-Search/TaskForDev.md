# Технический план реализации: Добавление медиа и поиск

## Архитектурные решения

Реализация будет разделена на два функциональных блока в рамках новых или существующих модулей:
1.  **Media Module**: Управление файлами, интеграция с Laravel Storage и обработка изображений.
2.  **Search Module**: Логика фильтрации и поиска по сущностям `FamilyMember`.

### Слои модулей:
-   **Domain**: Сущность `Media`, интерфейсы репозиториев, Value Objects для критериев поиска.
-   **Application**: UseCases для загрузки, удаления, установки аватара и выполнения поиска.
-   **Infrastructure**: Реализация хранилища (Laravel Storage), репозиториев (Eloquent), сервиса обработки изображений (Intervention Image).
-   **Presentation**: API Контроллеры, Resources для трансформации ответов.

## Модель предметной области

### Сущности (Domain/Entity)
-   `Media`: `id` (UUID), `ownerId` (UUID), `filePath`, `thumbnailPath`, `fileName`, `mimeType`, `fileSize`, `type` (Enum), `isPrimary` (bool).

### Объекты-значения (Domain/ValueObject)
-   `SearchCriteria`: `query`, `birthYear`, `deathYear`, `place`, `gender`.

### Интерфейсы (Domain)
-   `MediaRepositoryInterface`: `save(Media $media)`, `delete(string $id)`, `findByOwnerId(string $ownerId)`, `setPrimary(string $mediaId)`.
-   `FileStorageInterface`: `store(UploadedFile $file, string $path)`, `delete(string $path)`.
-   `ImageProcessorInterface`: `createThumbnail(string $path, int $width, int $height)`.

## Изменяемые файлы

### Новые файлы:
-   `backend/src/Media/Domain/Entity/Media.php`
-   `backend/src/Media/Domain/MediaRepositoryInterface.php`
-   `backend/src/Media/Application/UseCase/UploadMedia.php`
-   `backend/src/Media/Application/UseCase/DeleteMedia.php`
-   `backend/src/Media/Application/UseCase/SetPrimaryPhoto.php`
-   `backend/src/Media/Infrastructure/Repository/EloquentMediaRepository.php`
-   `backend/src/Media/Infrastructure/Service/LaravelFileStorage.php`
-   `backend/src/Media/Infrastructure/Service/InterventionImageProcessor.php`
-   `backend/src/Media/Presentation/Http/Controller/MediaController.php`
-   `backend/src/Search/Domain/ValueObject/SearchCriteria.php`
-   `backend/src/Search/Application/UseCase/SearchMembers.php`
-   `backend/src/Search/Presentation/Http/Controller/SearchController.php`
-   `backend/database/migrations/2026_01_14_000001_create_media_table.php`

### Изменяемые файлы:
-   `backend/routes/api.php`
-   `backend/config/filesystems.php`

## Последовательность действий

1.  **Инфраструктура и БД**:
    -   Создать миграцию для таблицы `gen_media`.
    -   Настроить диск `media` в `config/filesystems.php`.
    -   Установить `intervention/image` через composer.

2.  **Domain Layer (Media)**:
    -   Определить сущность `Media` и интерфейсы.

3.  **Infrastructure Layer (Media)**:
    -   Реализовать `LaravelFileStorage` и `InterventionImageProcessor`.
    -   Реализовать `EloquentMediaRepository`.

4.  **Application Layer (Media)**:
    -   Реализовать `UploadMedia` UseCase (валидация, сохранение файла, создание превью, запись в БД).
    -   Реализовать `DeleteMedia` и `SetPrimaryPhoto`.

5.  **Search Module**:
    -   Создать `SearchCriteria` VO.
    -   Реализовать `SearchMembers` UseCase с использованием Eloquent Query Builder для фильтрации.

6.  **Presentation Layer**:
    -   Создать контроллеры и зарегистрировать маршруты в `api.php`.

## Риски и альтернативы
-   **Риск**: Медленный поиск по текстовым полям.
-   **Решение**: Добавить индексы в SQLite. В будущем рассмотреть Scout/Algolia/Meilisearch.
-   **Риск**: Безопасность загрузки.
-   **Решение**: Использовать `MimeTypeGuesser` и валидацию Laravel.

## Чек-лист архитектурного соответствия
-   [ ] Логика работы с файлами скрыта за `FileStorageInterface`.
-   [ ] Обработка изображений вынесена в отдельный сервис.
-   [ ] Поиск инкапсулирован в UseCase.
-   [ ] Используются UUID для идентификации медиа.
