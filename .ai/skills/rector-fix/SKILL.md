---
name: rector-fix
description: Автоматическое улучшение кода (рефакторинг, модернизация)
context: isolated
argument-hint: "[path]"
allowed-tools: [Bash]
examples:
  - "/rector-fix"
  - "/rector-fix src/Module"
---

# Rector AutoFix

Автоматически улучшает PHP-код с помощью Rector: рефакторинг, модернизация, применение лучших практик.

## Использование

Рефакторинг всего проекта:

```bash
make php-run CMD="vendor/bin/rector process"
```

Конкретная директория:

```bash
make php-run CMD="vendor/bin/rector process src/Module"
```

## Что делает Rector

- Рефакторит код в соответствии с современными стандартами PHP
- Добавляет указания типов аргументов и возвращаемых значений
- Модернизирует устаревшие конструкции
- Применяет лучшие практики и паттерны
- Автоматически исправляет проблемы качества кода

## Требования

- Rector установлен через Composer
- Конфигурационный файл `rector.php` в корне проекта
