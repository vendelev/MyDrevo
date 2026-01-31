# Project Architecture

## Design Patterns & Principles

1. **CQRS (Command Query Responsibility Segregation)**
2. **Clean Architecture**
   - Multi-layered architecture with clear dependencies
   - Domain-driven design
   - Framework-independent business logic
3. **Modular Monolith**
   - Independent modules
   - Modular API and contracts
   - Clear module boundaries

## Key Conventions

- **Module**: A maximally self-sufficient part of the product responsible for specific functionality.
  Each module can contain public domain interfaces, entities, or events that define the boundaries of its usage (module API).

- **UseCase**: Implementation of a specific user behavior scenario (describes what the user wants to do).

- **DTO** (Data Transfer Object): Typed data structure for transfer between layers and modules.

- **Events** (Event): Specialized DTO for informing other modules about an event that occurred. Three types:
  - **Notifications** (Notification): DTO describing a message about a completed action in the past. Can be synchronous or asynchronous. Multiple recipients possible. Example: *patient was registered*.
  - **Queries** (Query): DTO describing a synchronous request for data retrieval. Exactly one recipient (one response). Example: *get patient history*.
  - **Commands** (Command): DTO describing a synchronous instruction to another module to perform an action (create, modify, delete data). Exactly one recipient (one handler). Example: *create journal entry*.

## Module Directory Structure

### Application

Contains the implementation of the module's business logic:

- **UseCase**: Main class implementing a use case. Coordinates the work of Command, Query, Service.
- **Command**: CQRS "command" class implementing data modification logic (create, update, delete). Direct database access is allowed to simplify implementation logic.
- **Query**: CQRS "query" class implementing data retrieval logic. Direct database access is allowed to simplify implementation logic.
- **Service**: Self-contained implementation of specific logic (framework-independent). Examples: calculator, parser, validator.
- **Dto**: Objects for data transfer within the Application layer. For example, UseCase receives RequestDTO, creates and enriches local DTO, passes DTO to Command.
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
- **Request**: DTO of incoming data in Controller/Console. Immutable.
- **Response**: DTO of outgoing data from Controller. Immutable.
- **Dto**: Structures for transfer between modules and layers. Immutable.
- **Entity**: Description of database table structure (used in Command and Repository). For logic simplification, Eloquent models are placed here.
- **ValueObject**: Narrowly specialized DTO, sometimes with built-in validation. Immutable.
- **Validation**: Classes for checking business requirements on data.
- **Event**: Notifications, Queries, Commands for interaction between modules. Immutable.
- **Exception**: Domain exceptions about errors in the Application layer.
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

- **Repository**: Simplified CQRS for database access.
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

Entry and exit point of the module:

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

This is the "maximum" complexity of a single module. It's not required to create all folders at once.

## Project Directory Structure

- **backend** - REST API and Console commands implementation
  - **bootstrap** - Laravel application initialization files
  - **config** - Laravel configuration files
  - **database**
    - **migrations** - Database migration files
    - **storage** - SQLite file storage
  - **src**
    - **Core** - Application core. Project-wide events, exceptions, framework and vendor wrappers. Structure similar to a module.
    - **{ModuleName}** - Functionality modules (structure as described above).
  - **tests**
    - **Architecture** - Architecture tests.
    - **Suite** - Application test suite.
      - **{ModuleName}** - Module tests.
    - **Stub** - Everything necessary for running tests. Example: universal fake-jwt.
      - **ModelFactory** - Files for generating database records for testing
    - **TestCase.php** - Abstract wrapper class over the framework.

- **docker** - Files for building Docker containers.
- **mock-server** - Configuration for [HTTP mock server](https://github.com/jmartin82/mmock)

## Layer Dependency Rules

**Each layer can use only its own and lower layers:**

| Layer              | Can Use                                                                                          |
|--------------------|--------------------------------------------------------------------------------------------------|
| **Presentation**   | Infrastructure (only own module), Application (only own module), Domain (own and other modules) |
| **Infrastructure** | Application (only own module), Domain (own and other modules)                                    |
| **Application**    | Application (only own module), Domain (preferably only own module)                               |
| **Domain**         | Domain (own and other modules)                                                                   |

**Dependency Injection (DI):**

- No need to create an interface if there's only one implementation. BUT for using Infrastructure implementation in the Application layer, you MUST create an interface in Domain.
- Example: Application uses `AuthenticationRepositoryInterface` (defined in Domain), which is implemented by `DatabaseAuthenticationRepository` (in Infrastructure).

## Module Dependencies

A module should be maximally independent from other modules, except for "Core".

Modules can interact with each other in two ways:

1. **Synchronously through interfaces**: "Module A" uses Domain interfaces of "Module B" through Anti-corruption layer (Adapter in Infrastructure).
2. **Synchronously/Asynchronously through events**: "Module A" generates Domain Event, subscribers (Listeners) of other modules process it.

## When to Create Interfaces

An interface (contract) is mandatory in the following cases:

1. **Within a module**: There are 2+ implementations of functionality.
   - Example: `CacheRepository` and `DatabaseRepository` both implement `RepositoryInterface`.
2. **For dependency inversion**: Application layer depends on Domain interface, which is implemented by Infrastructure.
3. **For module interaction**: When using functionality from another module, always through its Domain interface.

## Validation and Typing

### At Controller Level (Presentation)

**Structural** data characteristics are validated:

- Field requirements (required / nullable).
- Field types (string, int, array, etc.).
- Basic formats (email, date, etc.).
- Goal: Ensure that a typed DTO can be created from the incoming request.

**Tools:** ValidationInterface `$this->validator->validateData()`.

### At UseCase Level (Application)

**Business requirements** on data are validated:

- Logical constraints (is patient over 18 years old?).
- States (can the action be performed in the current status?).
- Accessibility (is there access to the resource?).
- Goal: Ensure correctness of the business process.

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
- **Private methods**: Associative arrays are allowed.
- **Goal**: Ensure type safety and document the contract of public methods.

## Responsibility Granularity in Classes

### Keep methods in one class if:

- A constructor dependency is used in **multiple methods** for similar functionality.
- Methods are responsible for one area of responsibility.

### Separate into different classes if:

- A constructor dependency is used in **2 methods out of 5+**.
- This indicates separation of responsibilities.
- Example: Creating a separate `NotificationService` instead of loading it in the main UseCase.
- **Advantage**: Avoid loading unused dependencies, improve testability.
