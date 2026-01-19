<?php

declare(strict_types=1);

namespace App\Example\Domain\ValueObject;

use App\Example\Domain\Exception\InvalidSubtractNumbersException;

final readonly class SubtractNumbersVO
{
    /**
     * @throws InvalidSubtractNumbersException
     */
    public function __construct(
        public float $number1,
        public float $number2,
    ) {
        if (bccomp((string)$number1, (string)$number2, 2) === 0) {
            throw InvalidSubtractNumbersException::numbersEqual();
        }
    }
}
