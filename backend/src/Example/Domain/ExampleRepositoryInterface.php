<?php

declare(strict_types=1);

namespace App\Example\Domain;

use App\Example\Domain\Dto\CreateExampleDto;

interface ExampleRepositoryInterface
{
    public function store(CreateExampleDto $example): int;
}
