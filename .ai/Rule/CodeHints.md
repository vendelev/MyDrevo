# Hints When Working with PHP Code

## Practical Recommendations

### ✅ DO

- Check neighboring files before implementation (conventions, imports, libraries).
- Use typing everywhere (parameters, return values).
- Create interfaces when dependency inversion is needed.
- Extract parsing and validation logic from Controller.
- Use public readonly properties in __construct instead of getters when no additional logic is needed.
- Make Entity and ValueObject immutable by adding final modifier.
- Always use dependency injection through constructor.
- Eloquent model MUST ALWAYS be located in `backend/src/{ModuleName}/Domain/Entity`. This is an exception.

### ❌ DON'T

- Don't use Eloquent models directly in Application layer.
- Don't create interfaces if there's only one implementation.
- Don't pass Laravel-Request between layers (use DTO).
- Don't load unused dependencies in constructor.
- Don't use `app()` to get class instances in controllers and elsewhere.
- Don't use `$this->app->singleton` in ServiceProvider.

## Module File Template Examples

### Application

- Command for processing outgoing messages - [`ExampleOutboxCommand.php`](../../backend/src/Example/Application/Command/ExampleOutboxCommand.php)
- DTO for calculated value - [`Calculated.php`](../../backend/src/Example/Application/Dto/Calculated.php)
- Simple DTO - [`ExampleDto.php`](../../backend/src/Example/Application/Dto/ExampleDto.php)
- Factory for creating example requests - [`ExampleRequestFactory.php`](../../backend/src/Example/Application/Factory/ExampleRequestFactory.php)
- Query for data retrieval - [`GetExampleQuery.php`](../../backend/src/Example/Application/Query/GetExampleQuery.php)
- Responder for report generation - [`ExampleMarkdownReportResponder.php`](../../backend/src/Example/Application/Responder/ExampleMarkdownReportResponder.php)
- Report template in markdown format - [`ExampleReport.md`](../../backend/src/Example/Application/Responder/Template/ExampleReport.md)
- Service for calculations - [`ExampleCalcService.php`](../../backend/src/Example/Application/Service/ExampleCalcService.php)
- Use cases (create and view) - [`ExampleUseCase.php`](../../backend/src/Example/Application/UseCase/ExampleUseCase.php)
- UseCase for subtraction operation - [`SubtractExampleUseCase.php`](../../backend/src/Example/Application/UseCase/SubtractExampleUseCase.php)

### Domain

- Domain overview documentation - [`overview.md`](../../backend/src/Example/Domain/Doc/overview.md)
- DTO for creation - [`CreateExampleDto.php`](../../backend/src/Example/Domain/Dto/CreateExampleDto.php)
- Enum - [`Status.php`](../../backend/src/Example/Domain/Dto/Status.php)
- Eloquent model - [`Example.php`](../../backend/src/Example/Domain/Entity/Example.php)
- Event: creation notification - [`ExampleCreated.php`](../../backend/src/Example/Domain/Event/ExampleCreated.php)
- Exception for not found example - [`ExampleNotFoundException.php`](../../backend/src/Example/Domain/Exception/ExampleNotFoundException.php)
- Exception for invalid numbers - [`InvalidSubtractNumbersException.php`](../../backend/src/Example/Domain/Exception/InvalidSubtractNumbersException.php)
- DTO request for creation - [`CreateExampleRequest.php`](../../backend/src/Example/Domain/Request/CreateExampleRequest.php)
- DTO response - [`ExampleResponse.php`](../../backend/src/Example/Domain/Response/ExampleResponse.php)
- Value object for created ID - [`CreatedIdVO.php`](../../backend/src/Example/Domain/ValueObject/CreatedIdVO.php)
- ValueObject with validation - [`SubtractNumbersVO.php`](../../backend/src/Example/Domain/ValueObject/SubtractNumbersVO.php)
- External logger interface - [`ExternalLoggerInterface.php`](../../backend/src/Example/Domain/ExternalLoggerInterface.php)
- Repository interface - [`ExampleRepositoryInterface.php`](../../backend/src/Example/Domain/ExampleRepositoryInterface.php)

### Infrastructure

- Adapter for ClickHouse logging - [`ClickhouseLogger.php`](../../backend/src/Example/Infrastructure/Adapter/ClickhouseLogger.php)
- Repository for working with Eloquent - [`EloquentExampleRepository.php`](../../backend/src/Example/Infrastructure/Repository/EloquentExampleRepository.php)

### Presentation

- Configuration file - [`example.php`](../../backend/src/Example/Presentation/Config/example.php)
- Service provider for module - [`ExampleServiceProvider.php`](../../backend/src/Example/Presentation/Config/ExampleServiceProvider.php)
- Console command - [`SubtractExampleCommand.php`](../../backend/src/Example/Presentation/Console/SubtractExampleCommand.php)
- Controller - [`ExampleController.php`](../../backend/src/Example/Presentation/Http/Controller/ExampleController.php)
- Middleware - [`ExampleMiddleware.php`](../../backend/src/Example/Presentation/Http/Middleware/ExampleMiddleware.php)
- Data display in html - [`dashboard.blade.php`](../../backend/src/Example/Presentation/Http/View/dashboard.blade.php)
- Event listener - [`ExampleCreatedListener.php`](../../backend/src/Example/Presentation/Listener/ExampleCreatedListener.php)

### Module Root
- Module documentation configuration - [`dochub.yaml`](../../backend/src/Example/dochub.yaml)
- Module description - [`Readme.md`](../../backend/src/Example/Readme.md)

## Interface and Implementation Registration

To bind interfaces and their implementations in Laravel dependency container use `bind` method:

```php
$this->app->bind(Interface::class, Implementation::class);
```

This allows easy replacement of implementations in tests and follows dependency inversion principle.

In other cases, declaring class in dependency container is NOT REQUIRED.

## ServiceProvider Registration

Each module can have its own ServiceProvider for registering components in dependency container.

### Registration in bootstrap/providers.php

All ServiceProviders must be registered in `backend/bootstrap/providers.php` file:

```php
<?php

use App\Core\Presentation\Config\CoreServiceProvider;
use App\Example\Presentation\Config\ExampleServiceProvider;

return [
    CoreServiceProvider::class,
    ExampleServiceProvider::class,
];
```

## Environment Variables Usage Guidelines

### General Principles

1. **Configuration through configuration files**: All application parameters should be accessible through Laravel configuration system.
2. **Using env() only in configuration files**: The `env()` function should be used only in configuration files in `config/` directory or in corresponding module files.
3. **Avoid direct env() use in business logic**: Never use `env()` directly in Application, Domain or Infrastructure layer classes.

### Correct Usage

1. Create configuration file in `Presentation/Config` directory of your module, example: [example.php](../../backend/src/Example/Presentation/Config/example.php)
2. To pass configuration values to classes use dependency container in ServiceProvider, example: [ExampleServiceProvider.php](../../backend/src/Example/Presentation/Config/ExampleServiceProvider.php)
3. In classes use dependency injection through constructor parameters to get values, example: [ClickhouseLogger.php](../../backend/src/Example/Infrastructure/Adapter/ClickhouseLogger.php)

### Approach Benefits

1. **Testability**: Configuration values can be easily replaced in tests.
2. **Flexibility**: Ability to override configuration through configuration files.
3. **Readability**: Explicit indication of configuration dependencies.
4. **Clean Architecture compliance**: Configuration is encapsulated in Presentation layer.

### Environment Variables in .env File

All environment variables must be defined in `.env.example` file with sample values and comments:

```env
# API Configuration
API_KEY=your_api_key_here
```
