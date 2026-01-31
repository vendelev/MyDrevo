# Workflow for Adding a New Feature


## 1. Planning (Domain Layer)

Start by defining the **domain model**:

- Which **Entities** are needed? (Entities representing real-world objects)
- Which **ValueObjects** are required? (Immutable values with validation)
- Which **interfaces** (contracts) are needed for other layers?
- Which **exceptions** should be thrown when business rules are violated?

## 2. Logic (Application Layer)

Implement a **UseCase** that coordinates the work:

- Use Domain interfaces through the constructor (dependency injection).
- Validate **business requirements** (statuses, availability, logical constraints).
- Coordinate the work of `Query`, `Command`, `Service`, and other components.
- Return a typed DTO (Response).

## 3. Integration (Infrastructure Layer)

Implement **Repository** and **Adapter** for access to external systems:

- Repository transforms domain Entities into Eloquent models.
- Adapter implements Domain interfaces for working with external services.
- Separate the logic: Repository for database, Adapter for services.

## 4. Entry Point (Presentation Layer)

Create a **Controller**, **Listener**, or **Console Command**:

- Controller receives a Request, validates structural data, calls UseCase.
- Listener responds to domain events from other modules.
- Console Command implements background tasks.

## 5. Testing

- **Unit tests** for Domain layer (Entity, ValueObject, Service).
- **Integration tests** for Infrastructure layer (UseCase, Query, Command, Repository, Adapter).
- **E2E tests** for the complete flow from HTTP request to response.
