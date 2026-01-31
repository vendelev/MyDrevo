---
name: rector-fix
description: Automatic code improvement (refactoring, modernization)
context: isolated
argument-hint: "[path]"
allowed-tools: [Bash]
examples:
  - "/rector-fix"
  - "/rector-fix src/Module"
---

# Rector AutoFix

Automatically improves PHP code using Rector: refactoring, modernization, applying best practices.

## Usage

Refactoring the entire project:

```bash
make php-run CMD="vendor/bin/rector process"
```

Specific directory:

```bash
make php-run CMD="vendor/bin/rector process src/Module"
```

## What Rector Does

- Refactors code according to modern PHP standards
- Adds type hints for arguments and return values
- Modernizes deprecated constructs
- Applies best practices and patterns
- Automatically fixes code quality issues

## Requirements

- Rector installed via Composer
- Configuration file `rector.php` in project root
