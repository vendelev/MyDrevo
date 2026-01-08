<?php

declare(strict_types=1);

use Parser\Backup\Presentation\Config\BackupServiceProvider;
use Parser\TicketDetail\Presentation\Config\TicketDetailServiceProvider;

return [
    BackupServiceProvider::class,
    TicketDetailServiceProvider::class,
];
