<?php

declare(strict_types=1);

namespace App\Example\Application\Dto;

final readonly class Calculated
{
    public function __construct(
        public float $number1,
        public float $number2,
        public float $result,
    ) {
    }
}
