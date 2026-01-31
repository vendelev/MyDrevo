---
name: phpcbf
description: Automatic code style fixing
context: isolated
argument-hint: "[path]"
allowed-tools: [Bash]
examples:
  - "/phpcbf"
  - "/phpcbf src/Module"
---

# PHPCBF AutoFix

Automatically fixes code style violations using PHP Code Beautifier and Fixer.

## Usage

Fix the entire project:

```bash
make php-run CMD="vendor/bin/phpcbf"
```

Specific directory:

```bash
make php-run CMD="vendor/bin/phpcbf src/Module"
```

Specific file:

```bash
make php-run CMD="vendor/bin/phpcbf src/Module/Service/Handler.php"
```

## What PHPCBF Does

- Fixes indentation and spacing
- Corrects line length violations
- Fixes brace placement
- Normalizes quotes and commas
- Applies PSR-12 code style standards
- Fixes naming conventions

## Requirements

- PHP_CodeSniffer installed via Composer
- Configuration file `phpcs.xml` in project root

## Note

PHPCBF can only fix violations that are amenable to automatic correction. For manual fixes, use PHPCS analysis.
