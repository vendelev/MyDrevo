<?php

declare(strict_types=1);

namespace App\Example\Domain\Response;

use App\Example\Domain\ValueObject\CreatedIdVO;

final readonly class ExampleResponse
{
    public function __construct(
        public CreatedIdVO $data,
    ) {
    }
}
