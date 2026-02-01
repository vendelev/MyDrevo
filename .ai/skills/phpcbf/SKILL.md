---
name: phpcbf
description: Автоматическое исправление стиля кода
context: isolated
argument-hint: "[path]"
allowed-tools: [Bash]
examples:
  - "/phpcbf"
  - "/phpcbf src/Module"
---

# PHPCBF AutoFix

Автоматически исправляет нарушения стиля кода с помощью PHP Code Beautifier and Fixer.

## Использование

Исправление всего проекта:

```bash
make php-run CMD="vendor/bin/phpcbf"
```

Конкретная директория:

```bash
make php-run CMD="vendor/bin/phpcbf src/Module"
```

Конкретный файл:

```bash
make php-run CMD="vendor/bin/phpcbf src/Module/Service/Handler.php"
```

## Что делает PHPCBF

- Исправляет отступы и пробелы
- Корректирует нарушения длины строк
- Исправляет расположение скобок
- Нормализует кавычки и запятые
- Применяет стандарты стиля кода PSR-12
- Исправляет соглашения об именовании

## Требования

- PHP_CodeSniffer установлен через Composer
- Конфигурационный файл `phpcs.xml` в корне проекта

## Примечание

PHPCBF может исправлять только нарушения, которые поддаются автоматической коррекции.
Для ручного исправления используйте анализ PHPCS.
