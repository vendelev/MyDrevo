<?php

declare(strict_types=1);

namespace App\Example\Presentation\Listener;

use App\Example\Domain\Event\ExampleCreated;
use App\Example\Domain\ExternalLoggerInterface;

final readonly class ExampleCreatedListener
{
    public function __construct(
        private ExternalLoggerInterface $logger,
    ) {
    }

    public function handle(ExampleCreated $event): bool
    {
        $this->logger->log('Created', ['exampleId' => $event->exampleId, 'userId' => $event->userId]);

        return true;
    }
}
