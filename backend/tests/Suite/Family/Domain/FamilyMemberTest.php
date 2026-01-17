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
            birthPlace: null,
            deathPlace: null,
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
            birthPlace: null,
            deathPlace: null,
            biography: 'Тестовая биография',
            userId: 1,
            createdAt: $createdAt,
            updatedAt: $updatedAt
        );

        $newFullName = new FullName('Петр', 'Петров', 'Петрович');
        $newUpdatedAt = new DateTimeImmutable('2026-01-01 11:00:00');
        $updatedFamilyMember = $familyMember->updateFullName($newFullName, $newUpdatedAt);

        self::assertEquals($newFullName, $updatedFamilyMember->fullName);
        self::assertEquals($familyMember->gender, $updatedFamilyMember->gender);
        self::assertEquals($familyMember->lifePeriod, $updatedFamilyMember->lifePeriod);
        self::assertEquals($familyMember->birthPlace, $updatedFamilyMember->birthPlace);
        self::assertEquals($familyMember->deathPlace, $updatedFamilyMember->deathPlace);
        self::assertEquals($familyMember->biography, $updatedFamilyMember->biography);
        self::assertEquals($familyMember->userId, $updatedFamilyMember->userId);
        self::assertEquals($familyMember->createdAt, $updatedFamilyMember->createdAt);
        self::assertEquals($newUpdatedAt, $updatedFamilyMember->updatedAt);
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
            birthPlace: 'Москва',
            deathPlace: 'Санкт-Петербург',
            biography: 'Тестовая биография',
            userId: 1,
            createdAt: $createdAt,
            updatedAt: $updatedAt
        );

        $newLifePeriod = new LifePeriod(
            new DateTimeImmutable('1990-01-01'),
            new DateTimeImmutable('2025-01-01')
        );
        $newUpdatedAt = new DateTimeImmutable('2026-01-01 11:00:00');
        $updatedFamilyMember = $familyMember->updateLifePeriod($newLifePeriod, $newUpdatedAt);

        self::assertEquals($newLifePeriod, $updatedFamilyMember->lifePeriod);
        self::assertEquals($familyMember->fullName, $updatedFamilyMember->fullName);
        self::assertEquals($familyMember->gender, $updatedFamilyMember->gender);
        self::assertEquals($familyMember->birthPlace, $updatedFamilyMember->birthPlace);
        self::assertEquals($familyMember->deathPlace, $updatedFamilyMember->deathPlace);
        self::assertEquals($familyMember->biography, $updatedFamilyMember->biography);
        self::assertEquals($familyMember->userId, $updatedFamilyMember->userId);
        self::assertEquals($familyMember->createdAt, $updatedFamilyMember->createdAt);
        self::assertEquals($newUpdatedAt, $updatedFamilyMember->updatedAt);
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
            birthPlace: null,
            deathPlace: null,
            biography: 'Тестовая биография',
            userId: 1,
            createdAt: $createdAt,
            updatedAt: $updatedAt
        );

        $newBiography = 'Обновленная биография';
        $newUpdatedAt = new DateTimeImmutable('2026-01-01 11:00:00');
        $updatedFamilyMember = $familyMember->updateBiography($newBiography, $newUpdatedAt);

        self::assertEquals($newBiography, $updatedFamilyMember->biography);
        self::assertEquals($familyMember->fullName, $updatedFamilyMember->fullName);
        self::assertEquals($familyMember->gender, $updatedFamilyMember->gender);
        self::assertEquals($familyMember->lifePeriod, $updatedFamilyMember->lifePeriod);
        self::assertEquals($familyMember->birthPlace, $updatedFamilyMember->birthPlace);
        self::assertEquals($familyMember->deathPlace, $updatedFamilyMember->deathPlace);
        self::assertEquals($familyMember->userId, $updatedFamilyMember->userId);
        self::assertEquals($familyMember->createdAt, $updatedFamilyMember->createdAt);
        self::assertEquals($newUpdatedAt, $updatedFamilyMember->updatedAt);
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
            birthPlace: null,
            deathPlace: null,
            biography: 'Тестовая биография',
            userId: 1,
            createdAt: $createdAt,
            updatedAt: $updatedAt
        );

        $newUpdatedAt = new DateTimeImmutable('2026-01-01 11:00:00');
        $updatedFamilyMember = $familyMember->updateBiography(null, $newUpdatedAt);

        self::assertNull($updatedFamilyMember->biography);
        self::assertEquals($familyMember->fullName, $updatedFamilyMember->fullName);
        self::assertEquals($familyMember->gender, $updatedFamilyMember->gender);
        self::assertEquals($familyMember->lifePeriod, $updatedFamilyMember->lifePeriod);
        self::assertEquals($familyMember->birthPlace, $updatedFamilyMember->birthPlace);
        self::assertEquals($familyMember->deathPlace, $updatedFamilyMember->deathPlace);
        self::assertEquals($familyMember->userId, $updatedFamilyMember->userId);
        self::assertEquals($familyMember->createdAt, $updatedFamilyMember->createdAt);
        self::assertEquals($newUpdatedAt, $updatedFamilyMember->updatedAt);
    }
}
