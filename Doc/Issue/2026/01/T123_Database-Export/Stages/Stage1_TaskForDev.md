# Этап 1. Доменная модель экспорта — план для разработчика

## Цель этапа

- Что добавляем/меняем в этом этапе: Создание базовых доменных сущностей, ValueObject и интерфейсов для функциональности экспорта данных.
- Что является критерием готовности: Определены контракты для экспорта, созданы базовые структуры данных без зависимостей от инфраструктуры.

## Общие архитектурные принципы

- Clean Architecture, CQRS, модульный монолит, Laravel.
- Не смешивать ответственность слоёв (Domain, Application, Infrastructure, Presentation).
- Стабильные контракты между слоями: интерфейсы, DTO, исключения.

## Архитектурные решения

Создание нового модуля Export для централизованного управления экспортом данных.

- **Domain**: Entity для ExportData, ValueObject для ExportFormat, интерфейсы для репозиториев других модулей (UserRepositoryInterface, FamilyRepositoryInterface, MediaRepositoryInterface).
- **Application**: Пока не затрагиваем.
- **Infrastructure**: Пока не затрагиваем.
- **Presentation**: Пока не затрагиваем.

## Структура модулей

- Модуль: `Export`
- Публичные точки входа: Интерфейсы для других модулей.
- Зависимости от других модулей: Auth (UserRepositoryInterface), будущие Family (FamilyRepositoryInterface), Media (MediaRepositoryInterface).

## Модель предметной области

- **Сущности**: ExportData (структура экспорта с данными пользователя, семьи, медиа).
- **Value Objects**: ExportFormat (JSON для MVP), MediaMetadata (имя, тип, дата).
- **DTO** (Application): Пока не определяем.
- **Исключения**: ExportFailedException (для ошибок экспорта).
- **Интерфейсы** (репозитории/шлюзы): UserDataProviderInterface, FamilyDataProviderInterface, MediaDataProviderInterface.

## Контракты и потоки данных (Mermaid)

```mermaid
sequenceDiagram
   participant ED as ExportData (Entity)
   participant EF as ExportFormat (VO)
   participant MM as MediaMetadata (VO)
   participant UDP as UserDataProviderInterface
   participant FDP as FamilyDataProviderInterface
   participant MDP as MediaDataProviderInterface

   Note over ED: Структура данных экспорта
   Note over EF: Формат экспорта (JSON)
   Note over MM: Метаданные медиа
   Note over UDP,FDP,MDP: Интерфейсы для получения данных
```

## Изменяемые файлы

Создать:

- `backend/src/Export/Domain/Entity/ExportData.php` — Сущность данных экспорта.
- `backend/src/Export/Domain/ValueObject/ExportFormat.php` — ValueObject формата экспорта.
- `backend/src/Export/Domain/ValueObject/MediaMetadata.php` — ValueObject метаданных медиа.
- `backend/src/Export/Domain/Exception/ExportFailedException.php` — Исключение для ошибок экспорта.
- `backend/src/Export/Domain/UserDataProviderInterface.php` — Интерфейс для получения данных пользователя.
- `backend/src/Export/Domain/FamilyDataProviderInterface.php` — Интерфейс для получения данных семьи.
- `backend/src/Export/Domain/MediaDataProviderInterface.php` — Интерфейс для получения метаданных медиа.
- `backend/src/Export/Domain/Doc/overview.md` — Документация модуля.

Изменить:

- Нет изменений в этом этапе.

## Последовательность действий

1. Создать структуру директорий модуля Export.
2. Реализовать ExportData entity с полями для userData, familyData, mediaData.
3. Создать ExportFormat ValueObject с поддержкой JSON.
4. Создать MediaMetadata ValueObject.
5. Определить ExportFailedException.
6. Создать интерфейсы для провайдеров данных.
7. Написать документацию overview.md.
8. Проверить типизацию и соответствие архитектуре.

## Риски и альтернативы

- Риск: Интерфейсы могут измениться при реализации других модулей → Митигировать: Использовать стабильные контракты.
- Альтернатива: Интегрировать экспорт в существующие модули вместо нового (не выбрали, чтобы сохранить разделение ответственности).

## Чек-лист архитектурного соответствия

- [x] CQRS: Не применимо на этом этапе.
- [x] Domain не зависит от Laravel/Infrastructure.
- [x] Application зависит от Domain, но не от Presentation.
- [x] Infrastructure реализует интерфейсы Application/Domain.
- [x] Контроллер тонкий: Не применимо.
- [x] Все публичные контракты задокументированы (DTO/PHPDoc).
