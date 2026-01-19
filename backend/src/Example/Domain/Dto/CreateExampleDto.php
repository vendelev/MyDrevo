<?php

declare(strict_types=1);

namespace App\Example\Domain\Dto;

use DateTimeImmutable;

final readonly class CreateExampleDto
{
    public function __construct(
        public string $name,
        public ?string $comment,
        public Status $status,
        public int $userId,
        public DateTimeImmutable $createdAt,
    ) {
    }
}
