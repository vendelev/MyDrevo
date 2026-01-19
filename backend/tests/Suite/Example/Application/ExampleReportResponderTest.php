<?php

declare(strict_types=1);

namespace Tests\Suite\Example\Application;

use App\Example\Application\Dto\Calculated;
use App\Example\Application\Responder\ExampleReportResponder;
use Tests\TestCase;

final class ExampleReportResponderTest extends TestCase
{
    public function testRenderMd(): void
    {
        // Arrange
        $data = [
            new Calculated(5.0, 3.0, 2.0),
            new Calculated(3.0, 5.0, -2.0),
        ];
        $format = 'md';

        $responder = new ExampleReportResponder();

        // Act
        $result = $responder->render($data, $format);

        // Assert
        self::assertStringContainsString('Число 1', $result);
        self::assertStringContainsString('Число 2', $result);
        self::assertStringContainsString('Результат', $result);
        self::assertStringContainsString('| 5 | 3 | 2 |', $result);
        self::assertStringContainsString('| 3 | 5 | -2 |', $result);
    }

    public function testRenderNotMd(): void
    {
        // Arrange
        $data = [new Calculated(1.0, 2.0, -1.0)];
        $format = 'txt';

        $responder = new ExampleReportResponder();

        // Act
        $result = $responder->render($data, $format);

        // Assert
        self::assertEquals('-', $result);
    }
}
