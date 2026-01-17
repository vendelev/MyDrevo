<?php

declare(strict_types=1);

namespace Tests\Suite\Family\Infrastructure;

use App\Family\Domain\Entity\FamilyMember;
use App\Family\Domain\ValueObject\FullName;
use App\Family\Domain\ValueObject\Gender;
use App\Family\Domain\ValueObject\LifePeriod;
use App\Family\Infrastructure\Repository\EloquentFamilyMemberRepository;
use DateTimeImmutable;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

final class EloquentFamilyMemberRepositoryTest extends TestCase
{
    private EloquentFamilyMemberRepository $repository;

    #[\Override]
    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new EloquentFamilyMemberRepository();

        // Создаем тестового пользователя
        DB::table('gen_user')->insert([
            'id' => 1,
            'login' => 'testuser',
            'password' => 'hashedpassword',
            'fname' => 'John',
            'sname' => 'Doe',
            'surname' => 'Smith',
            'email' => 'john@example.com',
            'user_type' => 1,
            'active' => 1,
            'create_date' => '2023-01-01 00:00:00',
        ]);
    }

    /**
     * @throws \App\Family\Domain\Exception\InvalidLifePeriodException
     * @throws \DateMalformedStringException
     * @throws \TypeError
     * @throws \ValueError
     */
    public function testSaveNewFamilyMember(): void
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

        $this->repository->save($familyMember);

        // Проверяем, что данные сохранились в БД
        $savedFamilyMember = $this->repository->findById(1);

        self::assertNotNull($savedFamilyMember);
        self::assertEquals(1, $savedFamilyMember->id);
        self::assertEquals($fullName->firstName, $savedFamilyMember->fullName->firstName);
        self::assertEquals($fullName->lastName, $savedFamilyMember->fullName->lastName);
        self::assertEquals($fullName->middleName, $savedFamilyMember->fullName->middleName);
        self::assertEquals(Gender::MALE, $savedFamilyMember->gender);
        self::assertEquals($lifePeriod->birthDate, $savedFamilyMember->lifePeriod->birthDate);
        self::assertEquals($lifePeriod->deathDate, $savedFamilyMember->lifePeriod->deathDate);
        self::assertEquals('Тестовая биография', $savedFamilyMember->biography);
        self::assertEquals(1, $savedFamilyMember->userId);
    }

    /**
     * @throws \App\Family\Domain\Exception\InvalidLifePeriodException
     * @throws \DateMalformedStringException
     * @throws \TypeError
     * @throws \ValueError
     */
    public function testFindByIdReturnsNullWhenNotFound(): void
    {
        $familyMember = $this->repository->findById(999);

        self::assertNull($familyMember);
    }

    /**
     * @throws \App\Family\Domain\Exception\InvalidLifePeriodException
     * @throws \DateMalformedStringException
     * @throws \TypeError
     * @throws \ValueError
     */
    public function testFindByUserId(): void
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
            birthPlace: 'Москва',
            deathPlace: 'Санкт-Петербург',
            biography: 'Тестовая биография',
            userId: 1,
            createdAt: $createdAt,
            updatedAt: $updatedAt
        );

        $this->repository->save($familyMember);

        $foundFamilyMember = $this->repository->findByUserId(1);

        self::assertNotNull($foundFamilyMember);
        self::assertEquals(1, $foundFamilyMember->userId);
    }

    /**
     * @throws \App\Family\Domain\Exception\InvalidLifePeriodException
     * @throws \DateMalformedStringException
     * @throws \TypeError
     * @throws \ValueError
     */
    public function testUpdateExistingFamilyMember(): void
    {
        // Создаем и сохраняем FamilyMember
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

        $this->repository->save($familyMember);

        // Обновляем данные, создавая новый экземпляр
        $updatedFullName = new FullName('Петр', 'Петров', 'Петрович');
        $updatedFamilyMember = new FamilyMember(
            id: $familyMember->id,
            fullName: $updatedFullName,
            gender: $familyMember->gender,
            lifePeriod: $familyMember->lifePeriod,
            birthPlace: $familyMember->birthPlace,
            deathPlace: $familyMember->deathPlace,
            biography: $familyMember->biography,
            userId: $familyMember->userId,
            createdAt: $familyMember->createdAt,
            updatedAt: new DateTimeImmutable('2026-01-01 11:00:00')
        );

        // Сохраняем обновленный FamilyMember
        $this->repository->save($updatedFamilyMember);

        // Проверяем, что данные обновились в БД
        $updatedFamilyMember = $this->repository->findById(1);

        self::assertNotNull($updatedFamilyMember);
        self::assertEquals('Петр', $updatedFamilyMember->fullName->firstName);
        self::assertEquals('Петров', $updatedFamilyMember->fullName->lastName);
        self::assertEquals('Петрович', $updatedFamilyMember->fullName->middleName);
    }

    /**
     * @throws \App\Family\Domain\Exception\InvalidLifePeriodException
     * @throws \DateMalformedStringException
     * @throws \TypeError
     * @throws \ValueError
     */
    public function testDeleteFamilyMember(): void
    {
        // Сначала создаем FamilyMember
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

        $this->repository->save($familyMember);

        // Удаляем FamilyMember
        $this->repository->delete(1);

        // Проверяем, что FamilyMember удален
        $deletedFamilyMember = $this->repository->findById(1);

        self::assertNull($deletedFamilyMember);
    }
}
