<?php

declare(strict_types=1);

namespace App\Example\Domain\ValueObject;

final readonly class CreatedIdVO
{
    public function __construct(
        public int $value
    ) {
    }
}
