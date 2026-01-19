<?php

declare(strict_types=1);

namespace App\Example\Domain\Exception;

use Exception;

class InvalidSubtractNumbersException extends Exception
{
    public static function numbersEqual(): self
    {
        return new self("Cannot subtract equal numbers.");
    }
}
