# Team-Accepted Code Style

--- 

## Class Imports

All full class names should be replaced with `use` operator at the beginning of the file.

### Example

Instead of:
```php
$response = new \App\Task\Domain\Response\TaskResponse();
```

Use:
```php
use App\Task\Domain\Response\TaskResponse;

// ...

$response = new TaskResponse();
```

### Exceptions

- Do not add `use` operator for built-in PHP types and functions (int, string, count(), etc.)
- Do not add `use` operator for classes in the same namespace

--- 

## Code Formatting Guidelines

1. **When writing tests:**
   - Use static PHPUnit method calls, for example (
    `self::assertTrue` instead of `$this->assertTrue`,
    `self::assertFalse` instead of `$this->assertFalse`,
    `self::assertSame` instead of `$this->assertSame`,
    `self::assertNull` instead of `$this->assertNull`,
    `self::assertEquals` instead of `$this->assertEquals`,
   )

2. **When writing code:**
   - Monitor line length (no more than 120 characters)
   - Split long lines into multiple lines for better readability
   - Do not override methods without changing logic
   - Always check code formatting after making changes
   - Use typed constants for improved type safety

3. **Code Documentation** (PHPDoc):
   - Add PHPDoc blocks for all public methods
   - Document parameters (@param) only for array descriptions
   - Document return value (@return) only for array descriptions
   - Document possible exceptions (@throws)
   - Add array types in PHPDoc in string comments for improved code analysis
   - For scalar arrays in PHPDocs, use `list<...>` instead of `array<...>`
   - Comments in code should be written in Russian

   **Exceptions**:
  - Comments may contain English terms related to code (e.g., @param, @return, @throws)
  - Class, method, and variable names in comments should preserve original spelling

   Example:
    ```php
    /**
    * Трансформирует DTO из API в доменную Entity.
    *
    * @param list<TicketApiDto> $dto DTO из Freshdesk API
    *
    * @return array<string, Ticket> Трансформированная сущность
    *
    * @throws InvalidTicketData Если данные не соответствуют требованиям
    */
    public function transformFromApi(array $dto, string $message): array
    {
        /** @var array<string, Ticket> $result */
        $result = [];
        // .... 
    }
    ```

4. **When working with Entity and DTO:**
  - Use public readonly properties instead of getters (according to PHP 8.5 capabilities)

5. **When working with interfaces:**
  - Remove unnecessary (@return void) from PHPDoc comments
  - Monitor correctness of method descriptions
