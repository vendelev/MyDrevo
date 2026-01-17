<?php

declare(strict_types=1);

namespace App\Family\Domain\Exception;

use Exception;

class InvalidLifePeriodException extends Exception
{
    public static function birthDateAfterDeathDate(): self
    {
        return new self('Birth date cannot be after death date.');
    }
}
