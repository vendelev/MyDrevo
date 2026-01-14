# Технический план реализации: Визуализация семейного дерева (Этап 3)

## 1. Архитектурные решения

### Backend (Laravel)
- **Модуль:** `FamilyTree` (новый модуль в `backend/src/FamilyTree`).
- **CQRS:**
    - **Query:** `GetFamilyTreeQuery` — получение структуры дерева.
- **Service:** `TreeBuilderService` — инкапсулирует логику рекурсивного обхода связей и формирования графа.
- **DTO:** `TreeNodeDTO` и `TreeEdgeDTO` для типизации ответа.

### Frontend (React/Vue - концептуально)
- **Библиотека:** Рекомендуется `React Flow` или `D3.js` для гибкой отрисовки.
- **Компонент:** `FamilyTreeCanvas` — отвечает за рендеринг, Zoom/Pan и обработку кликов.

## 2. Модели предметной области (Domain Models)

В рамках модуля `FamilyTree`:
- `FamilyTree` (Aggregate Root): Содержит коллекции `Nodes` и `Edges`.
- `Node`: `id`, `fullName`, `gender`, `birthDate`, `deathDate`, `photoUrl`.
- `Edge`: `sourceId`, `targetId`, `type` (parent-child, spouse).

## 3. Последовательность действий

### Шаг 1: Подготовка инфраструктуры Backend
1. Создать структуру директорий для модуля `FamilyTree`:
   - `backend/src/FamilyTree/Application/Queries`
   - `backend/src/FamilyTree/Domain/Models`
   - `backend/src/FamilyTree/Infrastructure/Controllers`
2. Зарегистрировать маршрут `GET /api/v1/family-tree/{root_id}` в `backend/src/FamilyTree/Infrastructure/routes.php`.

### Шаг 2: Реализация логики сбора данных (Domain & Application)
1. Реализовать `TreeBuilderService`:
   - Метод `build(string $rootId, int $depth, string $direction)`.
   - Использовать существующие репозитории из модуля `FamilyMember` (S2) для получения данных о персонах и связях.
   - Реализовать алгоритм предотвращения циклов (на случай некорректных данных в БД).
2. Реализовать `GetFamilyTreeHandler`:
   - Валидация входных параметров.
   - Проверка прав доступа (текущий пользователь должен иметь доступ к просмотру дерева этой персоны).
   - Вызов сервиса и возврат DTO.

### Шаг 3: Реализация API Controller
1. Создать `FamilyTreeController`:
   - Метод `show(string $root_id, Request $request)`.
   - Маппинг DTO в JSON-ответ согласно спецификации.

### Шаг 4: Frontend-компонент (Заглушка/Прототип)
1. Создать базовый компонент для визуализации.
2. Интегрировать библиотеку графов.
3. Реализовать переключение режимов (вертикальный/горизонтальный).

## 4. Изменения в БД
- Изменения в схеме не требуются (используются таблицы `gen_person`, `gen_relation`, `gen_name_lang` из S2).

## 5. Безопасность
- Проверка `Policy` для сущности `FamilyMember` при запросе дерева.
- Фильтрация чувствительных данных (например, точные даты рождения для живых людей, если это предусмотрено глобальными настройками приватности).
