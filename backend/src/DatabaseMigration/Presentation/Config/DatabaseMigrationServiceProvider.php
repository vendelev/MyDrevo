<?php

declare(strict_types=1);

namespace App\DatabaseMigration\Presentation\Config;

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
}