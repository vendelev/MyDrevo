<?php

declare(strict_types=1);

namespace App\Example\Domain\Exception;

use Exception;

class ExampleNotFoundException extends Exception
{
    public static function byId(int $id): self
    {
        return new self("Example with id {$id} not found.");
    }
}
