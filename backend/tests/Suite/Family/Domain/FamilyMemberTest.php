<?php

declare(strict_types=1);

namespace Tests\Suite\Family\Domain;

use App\Family\Domain\Entity\FamilyMember;
use App\Family\Domain\ValueObject\FullName;
use App\Family\Domain\ValueObject\Gender;
use App\Family\Domain\ValueObject\LifePeriod;
use DateTimeImmutable;
use Tests\TestCase;

final class FamilyMemberTest extends TestCase
{
    /**
     * @throws \App\Family\Domain\Exception\InvalidLifePeriodException
     */
    public function testFamilyMemberCreation(): void
    {
        $fullName = new FullName('Иван', 'Иванов', 'Иванович');
        $lifePeriod = new LifePeriod(
            new DateTimeImmutable('1980-01-01'),
            new DateTimeImmutable('2020-01-01')
        );
        $createdAt = new DateTimeImmutable('2026-01-01 10:00:00');
        $updatedAt = new DateTimeImmutable('2026-01-01 10:00:00');

        $familyMember = new FamilyMember(
            id: 1,
            fullName: $fullName,
            gender: Gender::MALE,
            lifePeriod: $lifePeriod,
            biography: 'Тестовая биография',
            userId: 1,
            createdAt: $createdAt,
            updatedAt: $updatedAt
        );

        self::assertEquals(1, $familyMember->id);
        self::assertEquals($fullName, $familyMember->fullName);
        self::assertEquals(Gender::MALE, $familyMember->gender);
        self::assertEquals($lifePeriod, $familyMember->lifePeriod);
        self::assertEquals('Тестовая биография', $familyMember->biography);
        self::assertEquals(1, $familyMember->userId);
        self::assertEquals($createdAt, $familyMember->createdAt);
        self::assertEquals($updatedAt, $familyMember->updatedAt);
    }

    /**
     * @throws \App\Family\Domain\Exception\InvalidLifePeriodException
     */
    public function testUpdateFullName(): void
    {
        $fullName = new FullName('Иван', 'Иванов', 'Иванович');
        $lifePeriod = new LifePeriod(new DateTimeImmutable('1980-01-01'));
        $createdAt = new DateTimeImmutable('2026-01-01 10:00:00');
        $updatedAt = new DateTimeImmutable('2026-01-01 10:00:00');

        $familyMember = new FamilyMember(
            id: 1,
            fullName: $fullName,
            gender: Gender::MALE,
            lifePeriod: $lifePeriod,
            biography: 'Тестовая биография',
            userId: 1,
            createdAt: $createdAt,
            updatedAt: $updatedAt
        );

        $newFullName = new FullName('Петр', 'Петров', 'Петрович');
        $familyMember->updateFullName($newFullName);

        self::assertEquals($newFullName, $familyMember->fullName);
        self::assertNotEquals($updatedAt, $familyMember->updatedAt);
        self::assertGreaterThan($updatedAt, $familyMember->updatedAt);
    }

    /**
     * @throws \App\Family\Domain\Exception\InvalidLifePeriodException
     */
    public function testUpdateLifePeriod(): void
    {
        $fullName = new FullName('Иван', 'Иванов', 'Иванович');
        $lifePeriod = new LifePeriod(new DateTimeImmutable('1980-01-01'));
        $createdAt = new DateTimeImmutable('2026-01-01 10:00:00');
        $updatedAt = new DateTimeImmutable('2026-01-01 10:00:00');

        $familyMember = new FamilyMember(
            id: 1,
            fullName: $fullName,
            gender: Gender::MALE,
            lifePeriod: $lifePeriod,
            biography: 'Тестовая биография',
            userId: 1,
            createdAt: $createdAt,
            updatedAt: $updatedAt
        );

        $newLifePeriod = new LifePeriod(
            new DateTimeImmutable('1990-01-01'),
            new DateTimeImmutable('2025-01-01')
        );
        $familyMember->updateLifePeriod($newLifePeriod);

        self::assertEquals($newLifePeriod, $familyMember->lifePeriod);
        self::assertNotEquals($updatedAt, $familyMember->updatedAt);
        self::assertGreaterThan($updatedAt, $familyMember->updatedAt);
    }

    /**
     * @throws \App\Family\Domain\Exception\InvalidLifePeriodException
     */
    public function testUpdateBiography(): void
    {
        $fullName = new FullName('Иван', 'Иванов', 'Иванович');
        $lifePeriod = new LifePeriod(new DateTimeImmutable('1980-01-01'));
        $createdAt = new DateTimeImmutable('2026-01-01 10:00:00');
        $updatedAt = new DateTimeImmutable('2026-01-01 10:00:00');

        $familyMember = new FamilyMember(
            id: 1,
            fullName: $fullName,
            gender: Gender::MALE,
            lifePeriod: $lifePeriod,
            biography: 'Тестовая биография',
            userId: 1,
            createdAt: $createdAt,
            updatedAt: $updatedAt
        );

        $newBiography = 'Обновленная биография';
        $familyMember->updateBiography($newBiography);

        self::assertEquals($newBiography, $familyMember->biography);
        self::assertNotEquals($updatedAt, $familyMember->updatedAt);
        self::assertGreaterThan($updatedAt, $familyMember->updatedAt);
    }

    /**
     * @throws \App\Family\Domain\Exception\InvalidLifePeriodException
     */
    public function testUpdateBiographyToNull(): void
    {
        $fullName = new FullName('Иван', 'Иванов', 'Иванович');
        $lifePeriod = new LifePeriod(new DateTimeImmutable('1980-01-01'));
        $createdAt = new DateTimeImmutable('2026-01-01 10:00:00');
        $updatedAt = new DateTimeImmutable('2026-01-01 10:00:00');

        $familyMember = new FamilyMember(
            id: 1,
            fullName: $fullName,
            gender: Gender::MALE,
            lifePeriod: $lifePeriod,
            biography: 'Тестовая биография',
            userId: 1,
            createdAt: $createdAt,
            updatedAt: $updatedAt
        );

        $familyMember->updateBiography(null);

        self::assertNull($familyMember->biography);
        self::assertNotEquals($updatedAt, $familyMember->updatedAt);
        self::assertGreaterThan($updatedAt, $familyMember->updatedAt);
    }
}
