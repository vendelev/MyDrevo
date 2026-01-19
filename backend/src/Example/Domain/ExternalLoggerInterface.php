<?php

declare(strict_types=1);

namespace App\Example\Domain;

interface ExternalLoggerInterface
{
    /**
     * @param array<string, mixed> $context
     */
    public function log(string $message, array $context = []): void;
}
