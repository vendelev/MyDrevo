<?php

declare(strict_types=1);

namespace Tests\Suite\Example\Presentation;

use App\Example\Domain\Event\ExampleCreated;
use App\Example\Domain\ExternalLoggerInterface;
use App\Example\Presentation\Listener\ExampleCreatedListener;
use Tests\TestCase;

final class ExampleCreatedListenerTest extends TestCase
{
    public function testHandleLogsEvent(): void
    {
        // Arrange
        $event = new ExampleCreated(exampleId: 123, userId: 456);

        $logger = $this->createMock(ExternalLoggerInterface::class);
        $logger->expects($this->once())
            ->method('log')
            ->with('Created', ['exampleId' => 123, 'userId' => 456]);

        $listener = new ExampleCreatedListener($logger);

        // Act
        $result = $listener->handle($event);

        // Assert
        self::assertTrue($result);
    }
}
