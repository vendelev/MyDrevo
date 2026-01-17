<?php

declare(strict_types=1);

namespace App\Family\Domain\ValueObject;

enum RelationshipType: string
{
    case PARENT = 'parent';
    case CHILD = 'child';
    case SPOUSE = 'spouse';
    case SIBLING = 'sibling';
}
