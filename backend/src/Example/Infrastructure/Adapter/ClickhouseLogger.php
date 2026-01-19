<?php

declare(strict_types=1);

namespace App\Example\Infrastructure\Adapter;

use App\Example\Domain\ExternalLoggerInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;

final readonly class ClickhouseLogger implements ExternalLoggerInterface
{
    public function __construct(
        private LoggerInterface $logger,
        private string $apiKey,
    ) {
    }

    public function log(string $message, array $context = []): void
    {
        $context['apiKey'] = $this->apiKey;

        $this->logger->log(LogLevel::INFO, $message, $context);
    }
}
