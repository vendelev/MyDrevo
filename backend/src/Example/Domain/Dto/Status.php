<?php

declare(strict_types=1);

namespace App\Example\Domain\Dto;

enum Status: string
{
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';

    /**
     * Привести список значений к формату Laravel Validator
     */
    public static function casesAsString(string $separator = ','): string
    {
        return implode($separator, array_column(self::cases(), 'value'));
    }
}
