# Project Architecture

## Design Patterns & Principles

1. **CQRS (Command Query Responsibility Segregation)**
2. **Clean Architecture**
   - Multi-layered architecture with clear dependencies
   - Domain-Driven Design
   - Business logic independent of framework
3. **Modular Monolith**
   - Independent modules
   - Modular APIs and contracts
   - Clear module boundaries

## Key Conventions

- **Module**: A maximally self-sufficient part of the product responsible for specific functionality.
  Each module can contain public domain interfaces, entities, or events defining its usage boundaries (module API).

- **UseCase**: Implementation of a specific user behavior scenario (describes what the user wants to do).

- **DTO** (Data Transfer Object): Typed data structure for transferring between layers and modules.

- **Events** (Event): Specialized DTO for informing other modules about an event. Three types:
  - **Notifications** (Notification): DTO describing a message about a completed action in the past. Can be synchronous or asynchronous. Multiple recipients possible. Example: *patient was registered*.
  - **Queries** (Query): DTO describing a synchronous request to retrieve data. Exactly one recipient (one response). Example: *get patient history*.
  - **Commands** (Command): DTO describing a synchronous instruction to another module to perform an action (create, modify, delete data). Exactly one recipient (one handler). Example: *create log entry*.

## Module Directory Structure

### Application

Contains module business logic implementation:

- **UseCase**: Main class implementing use case. Coordinates work of Command, Query, Service.
- **Command**: CQRS "command" class implementing data modification logic (create, update, delete). For simplicity, direct DB work is allowed.
- **Query**: CQRS "query" class implementing data retrieval logic. For simplicity, direct DB work is allowed.
- **Service**: Self-contained specific logic implementation (framework-independent). Example: calculator, parser, validator.
- **Dto**: Objects for data transfer within Application layer. For example, UseCase receives RequestDTO, creates and enriches local DTO, passes DTO to Command.
- **Factory**: Factory methods for creating DTO, Response, ValueObject.
- **Responder**: Generators of special content instead of JSON (Excel, PDF, email). Contains templates and generators.
  - **Template** - Any templates: email, Excel/Word, Telegram messages.
  - **{FileName}.php** - Response generator from template. Example: `CreateTaxExcelReport.php`

**Structure Example:**

```php
Patient/
├── Application/
│   ├── UseCase/
│   │   ├── CreatePatient.php
│   │   └── GetPatientHistory.php
│   ├── Command/
│   │   └── CreatePatientCommand.php
│   ├── Query/
│   │   └── GetPatientsByAgeQuery.php
│   ├── Service/
│   │   └── PatientAgeMapper.php
│   ├── Dto/
│   │   └── CreatePatientDto.php
│   ├── Responder/
│   │   └── CreateTaxExcelReport.php
│   └── Factory/
│       └── PatientFactory.php
```

### Domain

Subject area.
Public module API.
All entities here are accessible outside the module:

- **{InterfaceName}.php**: Contracts (interfaces) for dependency inversion and module interaction.
- **Request**: DTO for incoming data in Controller/Console. Immutable.
- **Response**: DTO for outgoing data from Controller. Immutable.
- **Dto**: Structures for transfer between modules and layers. Immutable.
- **Entity**: DB table structure description (used in Command and Repository). For simplicity, Eloquent models are placed here.
- **ValueObject**: Highly specialized DTO, sometimes with built-in validation. Immutable.
- **Validation**: Classes for checking business requirements on data.
- **Event**: Notifications, Queries, Commands for interaction between modules. Immutable.
- **Exception**: Domain exceptions about errors in Application layer.
- **Doc**: Module and its API documentation.

**Structure Example:**

```php
Patient/
├── Domain/
│   ├── Doc/
│   │   ├── Diagram.md
│   │   └── FreshDeskApi.md
│   ├── PatientRepositoryInterface.php
│   ├── Dto/
│   │   └── NotificationDto.php
│   ├── Request/
│   │   └── CreatePatientRequest.php
│   ├── Response/
│   │   └── PatientResponse.php
│   ├── Entity/
│   │   └── Patient.php
│   ├── ValueObject/
│   │   ├── PatientId.php
│   │   └── Email.php
│   ├── Validation/
│   │   └── PatientAgeValidation.php
│   ├── Event/
│   │   └── PatientCreatedNotification.php
│   └── Exception/
│       └── PatientNotFoundException.php
```

### Infrastructure

Implementation of integrations with external systems (Anti-corruption layer):

- **Repository**: Simplified CQRS for DB access.
- **Adapter**: Implements Domain interfaces for working with external services and other modules.
- **{ServiceName}**: Adapters for interaction with vendor libraries.

**Structure Example:**

```text
Patient/
├── Infrastructure/
│   └── Adapter/
│       └── ExternalMedicalServiceAdapter.php
├── RamseyUuid/
├── Repository/
```

### Presentation

Module entry and exit point:

- **Http/Controller**: HTTP controllers for handling REST requests.
- **Http/Middleware**: Middleware components.
- **Http/View**: HTML templates.
- **Console**: Cron scripts, daemons, console commands.
- **Listener**: Subscribers to domain events.
- **Config**: Module configuration (environment, DI, Service Container, routing).

**Structure Example:**

```text
Patient/
├── Presentation/
│   ├── Http/
│   │   ├── Controller/
│   │   │   └── PatientController.php
│   │   ├── Middleware/
│   │   │   └── AuthMiddleware.php
│   │   └── View/
│   │       └── auth.blade.php
│   ├── Console/
│   │   └── SyncPatientsCommand.php
│   ├── Listener/
│   │   └── PatientCreatedListener.php
│   └── Config/
│       └── PatientServiceProvider.php
```

This is the "maximum" complexity of one module. Not required to create all folders at once.

## Project Directory Structure

- **backend** - REST API and Console Commands implementation
  - **bootstrap** - Laravel application initialization files
  - **config** - Laravel configuration files
  - **database**
    - **migrations** - DB migration files
    - **storage** - SQLite file storage
  - **src**
    - **Core** - Application core. Project-wide events, exceptions, framework and vendor wrappers. Structure similar to module.
    - **{ModuleName}** - Functionality modules (structure as described above).
  - **tests**
    - **Architecture** - Architectural tests.
    - **Suite** - Application test suite.
      - **{ModuleName}** - Module tests.
    - **Stub** - Everything necessary for test execution. Example: universal fake-jwt.
      - **ModelFactory** - Files for generating DB records for testing
    - **TestCase.php** - Abstract wrapper class over framework.

- **docker** - Files for building Docker containers.
- **mock-server** - Configuration for [HTTP mock server](https://github.com/jmartin82/mmock)

## Layer Dependency Rules

**Each layer can only use its own and lower layers:**

| Layer              | Can Use                                                                                         |
|--------------------|-------------------------------------------------------------------------------------------------|
| **Presentation**   | Infrastructure (own module only), Application (own module only), Domain (own and other modules) |
| **Infrastructure** | Application (own module only), Domain (own and other modules)                                   |
| **Application**    | Application (own module only), Domain (preferably own module only)                              |
| **Domain**         | Domain (own and other modules)                                                                  |

**Dependency Injection (DI):**

- No need to create interface if there's only one implementation. BUT to use Infrastructure implementation in Application layer, you MUST create interface in Domain.
- Example: Application uses `AuthenticationRepositoryInterface` (defined in Domain), which is implemented by `DatabaseAuthenticationRepository` (in Infrastructure).

## Module Dependencies

Module should be maximally independent from other modules, except "Core".

Modules can interact with each other in two ways:

1. **Synchronously through interfaces**: "Module A" uses Domain interfaces of "Module B" through Anti-corruption layer (Adapter in Infrastructure).
2. **Synchronously/Asynchronously through events**: "Module A" generates Domain Event, subscribers (Listener) of other modules handle it.

## When to Create Interfaces

Interface (contract) is mandatory in the following cases:

1. **Within module**: There are 2+ functionality implementations.
   - Example: `CacheRepository` and `DatabaseRepository` both implement `RepositoryInterface`.
2. **For dependency inversion**: Application layer depends on Domain interface, which Infrastructure implements.
3. **For module interaction**: When using functionality from another module, always through its Domain interface.

## Validation and Typing

### At Controller Level (Presentation)

Validate **structural** data characteristics:

- Field requirements (required / nullable).
- Field types (string, int, array, etc.).
- Basic formats (email, date, etc.).
- Goal: Guarantee that typed DTO can be created from incoming request.

**Tools:** ValidationInterface `$this->validator->validateData()`.

### At UseCase Level (Application)

Validate **business requirements** on data:

- Logical constraints (is patient over 18 years old?).
- States (can action be performed in current status?).
- Availability (is there access to resource?).
- Goal: Guarantee business process correctness.

**Tools:** Validation classes in Domain, checks in UseCase or Service.

### For Complex Input Data

Extract parsing and validation logic from Controller:

```php
// In Controller:
$patientDto = PatientFactory::createFromRequest($request->validated());

// Or in Domain (ValueObject):
$email = new Email($request->input('email'));
```

### DTO Typing

- **Public and Protected methods**: Use typed DTOs as parameters and return values.
- **Private methods**: Using associative arrays is allowed.
- **Goal**: Ensure type safety and document public method contracts.

## Class Responsibility Granularity

### Keep methods in one class if:

- Constructor dependency is used in **multiple methods** for similar functionality.
- Methods are responsible for one area of responsibility.

### Split into different classes if:

- Constructor dependency is used in **2 methods out of 5+**.
- This indicates separation of responsibilities.
- Example: Creating separate `NotificationService` instead of loading into main UseCase.
- **Advantage**: Avoid loading unused dependencies, improve testability.
