# Технический план реализации: Визуализация семейного дерева (Этап 3)

## Архитектурное описание

- **Domain**: Сущность `FamilyTree`, Value Objects `TreeLayout`, `TreeConfiguration`. Интерфейсы репозиториев.
- **Application**: UseCases для генерации структуры дерева. Команды и Запросы.
- **Infrastructure**: Репозитории на базе Eloquent, маппинг доменных сущностей на таблицы `gen_*`.
- **Presentation**: REST API контроллеры, Request/Response DTO.

### Сущности (Entities)
- `FamilyTree`: ID (Integer), RootPersonId, Nodes, Edges.
- `TreeNode`: ID (Integer), Label, Gender, LifePeriod, PhotoUrl.
- `TreeEdge`: ID (Integer), SourceId, TargetId, RelationType.

### Value Objects
- `TreeLayout`: X, Y (Float).
- `TreeConfiguration`: Orientation (String), Depth (Integer).

## Технические требования

### Backend (Laravel)
1.  **Модуль `FamilyTree`:**
    - Расположение: `src/FamilyTree`.
    - Зависит от: `src/Family`.
2.  **Domain слой:**
    - `src/FamilyTree/Domain/Entity/FamilyTree.php`.
    - `src/FamilyTree/Domain/Entity/TreeNode.php`.
    - `src/FamilyTree/Domain/Entity/TreeEdge.php`.
    - `src/FamilyTree/Domain/ValueObject/TreeLayout.php`.
    - `src/FamilyTree/Domain/ValueObject/TreeConfiguration.php`.
    - `src/FamilyTree/Domain/Repository/FamilyTreeRepositoryInterface.php`.
3.  **Application слой:**
    - `src/FamilyTree/Application/UseCase/GenerateTreeUseCase.php`.
    - `src/FamilyTree/Application/Service/TreeBuilder.php`.
    - `src/FamilyTree/Application/Dto/GenerateTreeRequest.php`.
    - `src/FamilyTree/Application/Dto/GenerateTreeResponse.php`.
4.  **Infrastructure слой:**
    - `src/FamilyTree/Infrastructure/Repository/EloquentFamilyTreeRepository.php`.
    - `src/FamilyTree/Infrastructure/Mapper/TreeNodeMapper.php`.
    - `src/FamilyTree/Infrastructure/Mapper/TreeEdgeMapper.php`.
5.  **Presentation слой:**
    - `src/FamilyTree/Presentation/Http/Controller/FamilyTreeController.php`.
    - `src/FamilyTree/Presentation/Http/Request/GenerateTreeRequest.php`.
    - `src/FamilyTree/Presentation/Http/Response/GenerateTreeResponse.php`.
6.  **Маршруты:**
    - `GET /api/v1/family-tree/{root_id}` → `FamilyTreeController::generate`.

### Frontend (React/Vue)
1.  **Компоненты:**
    - `FamilyTreeGraph.vue` (или `.jsx`).
    - `TreeNode.vue`.
    - `TreeEdge.vue`.
2.  **Сервисы:**
    - `FamilyTreeApiService.js` — обертка над HTTP-запросами.
3.  **Библиотека визуализации:**
    - Выбор между D3.js, Cytoscape.js или React Flow.
4.  **Состояние:**
    - Использование Pinia/Vuex или React Context/Redux для хранения данных дерева.

## План разработки

### Подготовка
1.  **Шаг 1: Подготовка модуля**
    - Создать директорию `src/FamilyTree`.
    - Определить зависимости от `src/Family`.

### Domain
2.  **Шаг 2: Domain слой**
    - Создать Value Objects `TreeLayout` и `TreeConfiguration`.
    - Создать сущности `FamilyTree`, `TreeNode`, `TreeEdge`.
    - Определить интерфейс `FamilyTreeRepositoryInterface`.

### Application
3.  **Шаг 3: Application слой**
    - Создать DTO `GenerateTreeRequest` и `GenerateTreeResponse`.
    - Реализовать `TreeBuilder` сервис для сборки дерева из данных FamilyMember.
    - Реализовать `GenerateTreeUseCase`.

### Infrastructure
4.  **Шаг 4: Infrastructure слой**
    - Реализовать `EloquentFamilyTreeRepository`.
    - Создать мапперы `TreeNodeMapper` и `TreeEdgeMapper`.

### Presentation
5.  **Шаг 5: Presentation слой**
    - Создать контроллер `FamilyTreeController`.
    - Реализовать Request/Response DTO.
    - Добавить маршрут в `routes/api.php`.

### Frontend
6.  **Шаг 6: Frontend реализация**
    - Выбрать и интегрировать библиотеку визуализации.
    - Создать компонент `FamilyTreeGraph`.
    - Реализовать взаимодействие с Backend API.
    - Добавить интерактивность (Zoom, Pan, клики по узлам).

## Чек-лист архитектурного соответствия
- [x] Clean Architecture (слои разделены)
- [x] CQRS (разделение на Command/Query UseCases)
- [x] Модульный монолит (код в `src/FamilyTree`)
- [x] Domain-driven (бизнес-логика в Domain и Application)
