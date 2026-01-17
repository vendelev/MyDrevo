<?php

declare(strict_types=1);

namespace App\Family\Domain\ValueObject;

enum Gender: string
{
    case MALE = 'male';
    case FEMALE = 'female';
    case UNSPECIFIED = 'unspecified';
}
