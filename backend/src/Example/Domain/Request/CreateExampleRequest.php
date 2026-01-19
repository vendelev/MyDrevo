<?php

declare(strict_types=1);

namespace App\Example\Domain\Request;

use App\Example\Domain\Dto\Status;

final readonly class CreateExampleRequest
{
    public function __construct(
        public string $name,
        public ?string $comment,
        public Status $status,
        public int $userId,
    ) {
    }
}
