# Project Information

## Communication

All responses and interactions in **Russian language**.

## Summary

Educational project for creating a genealogical tree website using Specification-Driven Development and AI, using Laravel with full containerization via Docker.

### Main Components
- **Backend API**: Laravel service with Clean Architecture and CQRS
- **Database**: SQLite with migrations via Laravel

### Makefile Commands

The project uses Makefile to simplify frequent development tasks:

- `make install` - Build and start images, composer install, create test DB.
- `make up` - Start containers.
- `make down` - Stop and remove containers.
- `make update` - Rebuild and restart images, composer install.
- `make php-cli` - Bash into PHP container.
- `make php-log` - PHP container logs.
- `make php-run CMD="..."` - Execute command in PHP container. For example, `make php-run CMD="php artisan migrate"`

---

## Backend (PHP/Laravel)

**Configuration**: `backend/composer.json`

- **Language**: PHP 8.5.1
- **Framework**: Laravel 12.46.0
- **Build**: Composer
- **Structure**: Modular monolith with Clean Architecture and CQRS
- **Tests**: Unit, Integration, E2E
- **Static Analysis**: PHPStan, PHP_CodeSniffer, Rector

### Architecture

- Architecture rules in [Architecture.md](/.ai/rules/Architecture.md)

### Code Style

- PHP specifics for this project in [CodeHints.md](/.ai/rules/CodeHints.md)
- Team-accepted code style in [CodeStyle.md](/.ai/rules/CodeStyle.md)

### Testing

- Recommendations for writing tests in [Testing.md](/.ai/rules/Testing.md)

### Environment Variables

- **Backend**: `backend/.env.example` — template with comments
- **Backend**: `backend/.env.testing` — variables for running tests
- **Backend**: `backend/.env` — variables with actual values

### Backend Directory Structure

```text
backend/
├── src/
│   ├── Core/           (Project-wide code)
│   └── {ModuleName}/   (Feature modules)
├── database/
│   └── migrations/     (DB migrations)
├── tests/
│   ├── Suite/          (All application tests)
│   └── Stub/           (Fixtures and test data)
└── composer.json       (Dependencies)
```

---

## Database

- **DBMS**: SQLite
- **Schema Management**: Laravel migrations
- **Configuration**: Backend environment variables
- **Test DB**: Separate configuration for tests
