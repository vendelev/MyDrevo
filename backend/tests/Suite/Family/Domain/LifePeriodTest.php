<?php

declare(strict_types=1);

namespace Tests\Suite\Family\Domain;

use App\Family\Domain\Exception\InvalidLifePeriodException;
use App\Family\Domain\ValueObject\LifePeriod;
use DateTimeImmutable;
use Tests\TestCase;

final class LifePeriodTest extends TestCase
{
    /**
     * @throws InvalidLifePeriodException
     */
    public function testLifePeriodCreationWithBothDates(): void
    {
        $birthDate = new DateTimeImmutable('1980-01-01');
        $deathDate = new DateTimeImmutable('2020-01-01');

        $lifePeriod = new LifePeriod($birthDate, $deathDate);

        self::assertEquals($birthDate, $lifePeriod->birthDate);
        self::assertEquals($deathDate, $lifePeriod->deathDate);
    }

    /**
     * @throws InvalidLifePeriodException
     */
    public function testLifePeriodCreationWithOnlyBirthDate(): void
    {
        $birthDate = new DateTimeImmutable('1980-01-01');

        $lifePeriod = new LifePeriod($birthDate);

        self::assertEquals($birthDate, $lifePeriod->birthDate);
        self::assertNull($lifePeriod->deathDate);
    }

    /**
     * @throws InvalidLifePeriodException
     */
    public function testLifePeriodCreationWithOnlyDeathDate(): void
    {
        $deathDate = new DateTimeImmutable('2020-01-01');

        $lifePeriod = new LifePeriod(null, $deathDate);

        self::assertNull($lifePeriod->birthDate);
        self::assertEquals($deathDate, $lifePeriod->deathDate);
    }

    /**
     * @throws InvalidLifePeriodException
     */
    public function testLifePeriodCreationWithoutDates(): void
    {
        $lifePeriod = new LifePeriod();

        self::assertNull($lifePeriod->birthDate);
        self::assertNull($lifePeriod->deathDate);
    }

    /**
     * @throws InvalidLifePeriodException
     */
    public function testLifePeriodCreationWithInvalidDatesThrowsException(): void
    {
        $birthDate = new DateTimeImmutable('2020-01-01');
        $deathDate = new DateTimeImmutable('1980-01-01');

        $this->expectException(InvalidLifePeriodException::class);
        $this->expectExceptionMessage('Birth date cannot be after death date.');

        new LifePeriod($birthDate, $deathDate);
    }
}
