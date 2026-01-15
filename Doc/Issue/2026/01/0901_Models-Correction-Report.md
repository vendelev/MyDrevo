# Отчет о корректировке моделей в задачах с учетом импорта структуры БД

## Введение

В ходе проверки задач S0-S4 на соответствие реальной структуре базы данных, импортированной в рамках задачи S0, были выявлены несоответствия между моделями, описанными в спецификациях и технических планах, и реальной структурой таблиц `gen_*`. Ниже представлены исправленные версии документов с актуализированными моделями.

## Изменения в задаче S0 (Импорт структуры БД)

Файл: `Doc/Issue/2026/01/0901_S0_Database-Structure-Import/Spec.md`

Исправлена модель предметной области для соответствия реальной структуре БД:
- Уточнены типы идентификаторов (Integer вместо UUID).
- Добавлены недостающие поля в сущности `FamilyMember` и `Relationship`.
- Уточнены связи между таблицами.

## Изменения в задаче S1 (Базовая структура и аутентификация)

Файл: `Doc/Issue/2026/01/0901_S1_Base-Structure-and-Authentication/Spec.md`

Исправлена модель сущности `User`:
- `id`: Integer (соответствует `gen_user.ID`).
- `email`: String (соответствует `gen_user.EMAIL`).
- `passwordHash`: String (соответствует `gen_user.PASS`).
- `createdAt`: DateTime (соответствует `gen_user.CREATED_AT`).
- `lastLoginAt`: DateTime (соответствует `gen_user.LAST_LOGIN`).
- `isActive`: Boolean (соответствует `gen_user.IS_ACTIVE`).

Файл: `Doc/Issue/2026/01/0901_S1_Base-Structure-and-Authentication/TaskForDev.md`

Обновлен технический план:
- Уточнены сущности и интерфейсы репозиториев для соответствия реальной структуре таблицы `gen_user`.

## Изменения в задаче S2 (Профили членов семьи и связи)

Файл: `Doc/Issue/2026/01/0901_S2_Family-Member-Profiles-and-Relations/Spec.md`

Исправлена модель сущности `FamilyMember`:
- Добавлены недостающие поля: `gender`, `birthPlace`, `deathPlace`, `biography`, `createdAt`, `updatedAt`, `metadata`.
- Уточнен источник данных для поля `fullName`.

Исправлена модель сущности `Relationship`:
- Уточнены типы идентификаторов.
- Уточнены типы связей.

Файл: `Doc/Issue/2026/01/0901_S2_Family-Member-Profiles-and-Relations/TaskForDev.md`

Обновлен технический план:
- Уточнены сущности и интерфейсы репозиториев.
- Добавлены недостающие поля в модель `FamilyMember`.

## Изменения в задаче S3 (Визуализация семейного дерева)

Файл: `Doc/Issue/2026/01/0901_S3_Family-Tree-Visualization/Spec.md`

Уточнена модель предметной области:
- Уточнен источник данных для поля `gender` в `TreeNode`.
- Уточнена доступность поля `photoUrl`.

Файл: `Doc/Issue/2026/01/0901_S3_Family-Tree-Visualization/TaskForDev.md`

Обновлен технический план:
- Уточнены сущности и интерфейсы репозиториев.

## Изменения в задаче S4 (Медиа и поиск)

Файл: `Doc/Issue/2026/01/0901_S4_Media-and-Search/Spec.md`

Исправлена модель сущности `Media`:
- `id`: Integer (соответствует `gen_media.ID`).
- `fileName`: String (соответствует `gen_media.FILE_NAME`).
- `fileType`: String (соответствует `gen_media.FILE_TYPE`).
- `fileSize`: Integer (соответствует `gen_media.FILE_SIZE`).
- `filePath`: String (соответствует `gen_media.FILE_PATH`).
- `previewPath`: String (соответствует `gen_media.PREVIEW_PATH`).
- `description`: String (соответствует `gen_media.DESCRIPTION`).
- `uploadedAt`: DateTime (соответствует `gen_media.UPLOADED_AT`).
- `ownerId`: `FamilyMemberId` (соответствует `gen_media.PERSON_ID`).
- `isPublic`: Boolean (соответствует `gen_media.IS_PUBLIC`).

Файл: `Doc/Issue/2026/01/0901_S4_Media-and-Search/TaskForDev.md`

Обновлен технический план:
- Уточнены сущности и интерфейсы репозиториев для соответствия реальной структуре таблицы `gen_media`.

## Заключение

Все задачи S0-S4 были обновлены для соответствия реальной структуре базы данных. Исправленные версии документов находятся в соответствующих директориях. Теперь модели предметной области точно отражают структуру таблиц `gen_*`, что обеспечит корректную реализацию функциональности.
