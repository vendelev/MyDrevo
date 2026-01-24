# Workflow When Adding New Feature


## 1. Planning (Domain Layer)

Start by defining the **domain model**:

- What **Entities** are needed? (Entities representing real-world objects)
- What **ValueObjects** are required? (Immutable values with validation)
- What **interfaces** (contracts) are needed by other layers?
- What **exceptions** should be thrown when business rules are violated?

## 2. Logic (Application Layer)

Implement **UseCase** coordinating the work:

- Use Domain interfaces through constructor (dependency injection).
- Validate **business requirements** (statuses, availability, logical constraints).
- Coordinate work of `Query`, `Command`, `Service` and other components.
- Return typed DTO (Response).

## 3. Integration (Infrastructure Layer)

Implement **Repository** and **Adapter** for accessing external systems:

- Repository converts domain Entities to Eloquent models.
- Adapter implements Domain interfaces for working with external services.
- Separate logic: Repository for DB, Adapter for services.

## 4. Entry Point (Presentation Layer)

Create **Controller**, **Listener** or **Console Command**:

- Controller receives Request, validates structural data, calls UseCase.
- Listener reacts to domain events from other modules.
- Console Command implements background tasks.

## 5. Testing

- **Unit tests** for Domain layer (Entity, ValueObject, Service).
- **Integration tests** for Infrastructure layer (UseCase, Query, Command, Repository, Adapter).
- **E2E tests** for complete flow from HTTP request to response.
