<?php

declare(strict_types=1);

namespace Tests\Suite\Example\Application;

use App\Example\Application\Service\ExampleCalcService;
use Tests\TestCase;

final class ExampleCalcServiceTest extends TestCase
{
    public function testSubtract(): void
    {
        // Arrange
        $num1 = 5.0;
        $num2 = 3.0;
        $expected = 2.0;

        $service = new ExampleCalcService();

        // Act
        $result = $service->subtract($num1, $num2);

        // Assert
        self::assertEquals($expected, $result);
    }
}
