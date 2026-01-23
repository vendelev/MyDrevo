<?php

declare(strict_types=1);

namespace App\DatabaseMigration\Presentation\Config;

use App\DatabaseMigration\Presentation\Console\Commands\ExportMySQLCommand;
use App\DatabaseMigration\Presentation\Console\Commands\ImportDatabaseCommand;
use App\DatabaseMigration\Presentation\Console\Commands\ValidateIntegrityCommand;
use Illuminate\Support\ServiceProvider;

/**
 * ServiceProvider для модуля DatabaseMigration.
 */
final class DatabaseMigrationServiceProvider extends ServiceProvider
{
    /**
     * Регистрация команд модуля.
     */
    public function register(): void
    {
        // Регистрация команд будет добавлена на этапе реализации
    }

    /**
     * Загрузка команд модуля.
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                ExportMySQLCommand::class,
                ImportDatabaseCommand::class,
                ValidateIntegrityCommand::class,
            ]);
        }
    }
}