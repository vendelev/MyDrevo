<?php

declare(strict_types=1);

namespace App\Example\Application\Service;

final readonly class ExampleCalcService
{
    public function subtract(float $num1, float $num2): float
    {
        return $num1 - $num2;
    }
}
