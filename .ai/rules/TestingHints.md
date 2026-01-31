# Testing

**Test Writing Features**:
- Test methods must start with the word test, the "@test" annotation doesn't work
- Test classes must extend Tests\TestCase, not PHPUnit\Framework\TestCase
- Controllers should only be tested via E2E tests
- For controllers returning View, verify template content (render())
- For UseCase testing, use Integration tests; the constructor may have `final class` dependencies
- Don't use Mockery
- Use `$this->service` instead of `app()`.
  Example: app(ValidationFactoryInterface::class) -> $this->service(ValidationFactoryInterface::class)
- For Integration and E2E tests, create database records using classes in the [ModelFactory](../../backend/tests/Stub/ModelFactory) folder

**When to Write Tests**:
- ✅ All components in Application and Domain layers **MUST** be tested
- ❌ Tests for configuration and simple DTOs are **NOT NEEDED** (if they don't contain logic)
- ✅ Infrastructure layer (Repository, Adapter) must be tested (Integration tests with DB)
- ✅ Presentation layer (Command, Listener) must be tested (E2E tests)

**Minimum Requirements**:
- For each public method — at least one positive test
- For methods with validation — tests for invalid data
- For methods with dependencies — use Mock/Stub objects

## Test Types

The test file structure should mirror the module structure.
Separation by test type is only logical.

### Unit Tests

Testing individual components in isolation (without dependencies).

- **Location**: `backend/tests/Suite/{ModuleName}/Application`, `backend/tests/Suite/{ModuleName}/Domain`
- **Covers**:
  - Business logic in Service
  - Validation in Validation classes
  - Logic in Domain objects and ValueObject

### Integration Tests

Testing individual components when interacting with the database.

- **Location**: `backend/tests/Suite/{ModuleName}/Application/UseCase`, `backend/tests/Suite/{ModuleName}/Application/Query`, `backend/tests/Suite/{ModuleName}/Application/Command`
- **Covers**:
  - Business logic in UseCase, Query, Command

Testing component interaction with external systems.

- **Location**: `backend/tests/Suite/{ModuleName}/Infrastructure`
- **Covers**:
  - Adapter (interaction with external services)
  - Anti-corruption layer between modules

### End-To-End (E2E) Tests

Testing the complete flow: from HTTP request to response, including all layers.

- **Location**: `backend/tests/Suite/{ModuleName}/Presentation`
- **Covers**:
  - HTTP controllers and routes
  - Middleware
  - Complete lifecycle of request and data

## Module File Template Examples

### Application

- Unit test for Service - [`ExampleCalcServiceTest.php`](../../backend/tests/Suite/Example/Application/ExampleCalcServiceTest.php)
- Integration test for Command - [`ExampleOutboxCommandTest.php`](../../backend/tests/Suite/Example/Application/ExampleOutboxCommandTest.php)
- Unit test for Responder - [`ExampleReportResponderTest.php`](../../backend/tests/Suite/Example/Application/ExampleReportResponderTest.php)
- Unit test for Factory - [`ExampleRequestFactoryTest.php`](../../backend/tests/Suite/Example/Application/ExampleRequestFactoryTest.php)
- Integration test for UseCase - [`ExampleUseCaseTest.php`](../../backend/tests/Suite/Example/Application/ExampleUseCaseTest.php)
- Integration test for Query - [`GetExampleQueryTest.php`](../../backend/tests/Suite/Example/Application/GetExampleQueryTest.php)

### Domain

- Unit test for exception - [`ExampleNotFoundExceptionTest.php`](../../backend/tests/Suite/Example/Domain/ExampleNotFoundExceptionTest.php)
- Unit test for ValueObject with validation - [`SubtractNumbersVOTest.php`](../../backend/tests/Suite/Example/Domain/SubtractNumbersVOTest.php)

### Infrastructure

- Integration test for adapter - [`ClickhouseLoggerTest.php`](../../backend/tests/Suite/Example/Infrastructure/ClickhouseLoggerTest.php)
- Integration test for repository - [`EloquentExampleRepositoryTest.php`](../../backend/tests/Suite/Example/Infrastructure/EloquentExampleRepositoryTest.php)

### Presentation

- E2E test for controller - [`ExampleControllerTest.php`](../../backend/tests/Suite/Example/Presentation/ExampleControllerTest.php)
- E2E test for event listener - [`ExampleCreatedListenerTest.php`](../../backend/tests/Suite/Example/Presentation/ExampleCreatedListenerTest.php)
- E2E test for middleware - [`ExampleMiddlewareTest.php`](../../backend/tests/Suite/Example/Presentation/ExampleMiddlewareTest.php)
- E2E test for console command - [`SubtractExampleCommandTest.php`](../../backend/tests/Suite/Example/Presentation/SubtractExampleCommandTest.php)
