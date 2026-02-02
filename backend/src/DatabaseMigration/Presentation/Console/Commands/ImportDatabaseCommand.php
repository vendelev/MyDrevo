<?php

declare(strict_types=1);

namespace App\DatabaseMigration\Presentation\Console\Commands;

use Illuminate\Console\Command;

/**
 * Команда импорта данных из JSON в SQLite.
 */
final class ImportDatabaseCommand extends Command
{
    /**
     * Имя команды.
     */
    protected $signature = 'db:import
        {--file= : Path to export file}
        {--validate : Validate file without importing}
        {--tables= : Comma-separated list of tables}
        {--skip-existing : Skip records with existing IDs}
        {--truncate : Truncate tables before import}';

    /**
     * Описание команды.
     */
    protected $description = 'Импорт данных из JSON файла в SQLite';

    /**
     * Выполнить команду.
     */
    public function handle(): int
    {
        $this->info('TODO: Реализовать импорт данных на этапе 4');

        return self::SUCCESS;
    }
}
