<?php

declare(strict_types=1);

namespace App\DatabaseMigration\Presentation\Console\Commands;

use Illuminate\Console\Command;

/**
 * Команда экспорта данных из MySQL в JSON файл.
 */
final class ExportMySQLCommand extends Command
{
    /**
     * Имя команды.
     */
    protected $signature = 'db:export-mysql
        {--host= : MySQL host}
        {--database= : Database name}
        {--user= : MySQL user}
        {--password= : MySQL password}
        {--port=3306 : MySQL port}
        {--output= : Output file path}
        {--tables= : Comma-separated list of tables}';

    /**
     * Описание команды.
     */
    protected $description = 'Экспорт данных из MySQL в JSON файл';

    /**
     * Выполнить команду.
     */
    public function handle(): int
    {
        $this->info('TODO: Реализовать экспорт данных на этапе 3');

        return self::SUCCESS;
    }
}