<?php

declare(strict_types=1);

namespace Tests\Suite\Example\Infrastructure;

use App\Example\Infrastructure\Adapter\ClickhouseLogger;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;
use Tests\TestCase;

final class ClickhouseLoggerTest extends TestCase
{
    public function testLog(): void
    {
        // Arrange
        $apiKey = 'test-api-key';
        $message = 'Test message';
        $additionalContext = ['userId' => 123];

        $logger = $this->createMock(LoggerInterface::class);
        $logger->expects($this->once())
            ->method('log')
            ->with(
                LogLevel::INFO,
                $message,
                self::callback(
                    static fn($context): bool => isset($context['apiKey'], $context['userId'])
                        && $context['apiKey'] === $apiKey && $context['userId'] === 123
                )
            );

        $clickhouseLogger = new ClickhouseLogger($logger, $apiKey);

        // Act
        $clickhouseLogger->log($message, $additionalContext);
    }
}
