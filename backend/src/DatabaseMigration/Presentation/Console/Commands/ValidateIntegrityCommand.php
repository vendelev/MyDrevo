<?php

declare(strict_types=1);

namespace App\DatabaseMigration\Presentation\Console\Commands;

use Illuminate\Console\Command;

/**
 * Команда проверки целостности данных в БД.
 */
final class ValidateIntegrityCommand extends Command
{
    /**
     * Имя команды.
     */
    protected $signature = 'db:validate-integrity
        {--verbose : Show detailed output}
        {--format=text : Output format (text|json)}
        {--fix : Auto-fix issues}';

    /**
     * Описание команды.
     */
    protected $description = 'Проверка целостности данных в БД';

    /**
     * Выполнить команду.
     */
    public function handle(): int
    {
        $this->info('TODO: Реализовать проверку целостности на этапе 5');

        return self::SUCCESS;
    }
}