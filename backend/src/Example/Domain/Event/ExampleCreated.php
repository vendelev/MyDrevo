<?php

declare(strict_types=1);

namespace App\Example\Domain\Event;

final readonly class ExampleCreated
{
    public function __construct(
        public int $exampleId,
        public int $userId,
    ) {
    }
}
