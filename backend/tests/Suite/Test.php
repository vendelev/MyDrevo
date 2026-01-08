<?php

declare(strict_types=1);

namespace Tests\Suite;

use Tests\TestCase;

final class Test extends TestCase
{
    public function testIt(): void
    {
        self::assertEquals(1, 1);
    }
}
