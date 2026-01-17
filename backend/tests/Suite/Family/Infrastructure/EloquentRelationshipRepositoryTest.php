<?php

declare(strict_types=1);

namespace Tests\Suite\Family\Infrastructure;

use App\Family\Domain\Entity\Relationship;
use App\Family\Domain\ValueObject\RelationshipType;
use App\Family\Infrastructure\Repository\EloquentRelationshipRepository;
use DateTimeImmutable;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

final class EloquentRelationshipRepositoryTest extends TestCase
{
    private EloquentRelationshipRepository $repository;

    #[\Override]
    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new EloquentRelationshipRepository();

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

        // Создаем тестовых членов семьи
        DB::table('family_members')->insert([
            [
                'id' => 1,
                'user_id' => 1,
                'first_name' => 'Иван',
                'last_name' => 'Иванов',
                'middle_name' => 'Иванович',
                'gender' => 'male',
                'birth_date' => '1980-01-01',
                'death_date' => '2020-01-01',
                'biography' => 'Тестовая биография',
                'created_at' => '2026-01-01 10:00:00',
                'updated_at' => '2026-01-01 10:00:00',
            ],
            [
                'id' => 2,
                'user_id' => 1,
                'first_name' => 'Мария',
                'last_name' => 'Иванова',
                'middle_name' => 'Ивановна',
                'gender' => 'female',
                'birth_date' => '1985-01-01',
                'death_date' => null,
                'biography' => 'Тестовая биография 2',
                'created_at' => '2026-01-01 10:00:00',
                'updated_at' => '2026-01-01 10:00:00',
            ],
            [
                'id' => 3,
                'user_id' => 1,
                'first_name' => 'Петр',
                'last_name' => 'Иванов',
                'middle_name' => 'Иванович',
                'gender' => 'male',
                'birth_date' => '2010-01-01',
                'death_date' => null,
                'biography' => 'Тестовая биография 3',
                'created_at' => '2026-01-01 10:00:00',
                'updated_at' => '2026-01-01 10:00:00',
            ],
        ]);
    }

    /**
     * @throws \DateMalformedStringException
     * @throws \TypeError
     * @throws \ValueError
     */
    public function testSaveNewRelationship(): void
    {
        $createdAt = new DateTimeImmutable('2026-01-01 10:00:00');
        $updatedAt = new DateTimeImmutable('2026-01-01 10:00:00');

        $relationship = new Relationship(
            id: 1,
            personId: 1,
            relativeId: 2,
            type: RelationshipType::PARENT,
            metadata: null,
            createdAt: $createdAt,
            updatedAt: $updatedAt
        );

        $this->repository->save($relationship);

        // Проверяем, что данные сохранились в БД
        $savedRelationship = $this->repository->findById(1);

        self::assertNotNull($savedRelationship);
        self::assertEquals(1, $savedRelationship->id);
        self::assertEquals(1, $savedRelationship->personId);
        self::assertEquals(2, $savedRelationship->relativeId);
        self::assertEquals(RelationshipType::PARENT, $savedRelationship->type);
        self::assertNull($savedRelationship->metadata);
        self::assertEquals($createdAt, $savedRelationship->createdAt);
        self::assertEquals($updatedAt, $savedRelationship->updatedAt);
    }

    /**
     * @throws \DateMalformedStringException
     * @throws \TypeError
     * @throws \ValueError
     */
    public function testFindByIdReturnsNullWhenNotFound(): void
    {
        $relationship = $this->repository->findById(999);

        self::assertNull($relationship);
    }

    /**
     * @throws \DateMalformedStringException
     * @throws \TypeError
     * @throws \ValueError
     */
    public function testFindByPersonId(): void
    {
        // Создаем несколько связей для одного personId
        $createdAt = new DateTimeImmutable('2026-01-01 10:00:00');
        $updatedAt = new DateTimeImmutable('2026-01-01 10:00:00');

        $relationship1 = new Relationship(
            id: 1,
            personId: 1,
            relativeId: 2,
            type: RelationshipType::PARENT,
            metadata: null,
            createdAt: $createdAt,
            updatedAt: $updatedAt
        );

        $relationship2 = new Relationship(
            id: 2,
            personId: 1,
            relativeId: 3,
            type: RelationshipType::SPOUSE,
            metadata: null,
            createdAt: $createdAt,
            updatedAt: $updatedAt
        );

        $this->repository->save($relationship1);
        $this->repository->save($relationship2);

        // Получаем связи по personId
        $relationships = $this->repository->findByPersonId(1);

        self::assertCount(2, $relationships);
        self::assertEquals(1, $relationships[0]->personId);
        self::assertEquals(1, $relationships[1]->personId);
    }

    /**
     * @throws \DateMalformedStringException
     * @throws \TypeError
     * @throws \ValueError
     */
    public function testUpdateExistingRelationship(): void
    {
        // Создаем и сохраняем Relationship
        $createdAt = new DateTimeImmutable('2026-01-01 10:00:00');
        $updatedAt = new DateTimeImmutable('2026-01-01 10:00:00');

        $relationship = new Relationship(
            id: 1,
            personId: 1,
            relativeId: 2,
            type: RelationshipType::PARENT,
            metadata: null,
            createdAt: $createdAt,
            updatedAt: $updatedAt
        );

        $this->repository->save($relationship);

        // Обновляем данные
        $updatedRelationship = new Relationship(
            id: 1,
            personId: 1,
            relativeId: 3, // Изменяем relativeId
            type: RelationshipType::CHILD, // Изменяем тип
            metadata: '{"test": "value"}', // Добавляем metadata
            createdAt: $createdAt,
            updatedAt: new DateTimeImmutable('2026-01-02 10:00:00') // Обновляем updatedAt
        );

        // Сохраняем обновленный Relationship
        $this->repository->save($updatedRelationship);

        // Проверяем, что данные обновились в БД
        $savedRelationship = $this->repository->findById(1);

        self::assertNotNull($savedRelationship);
        self::assertEquals(3, $savedRelationship->relativeId);
        self::assertEquals(RelationshipType::CHILD, $savedRelationship->type);
        self::assertEquals('{"test": "value"}', $savedRelationship->metadata);
    }

    /**
     * @throws \DateMalformedStringException
     * @throws \TypeError
     * @throws \ValueError
     */
    public function testDeleteRelationship(): void
    {
        // Сначала создаем Relationship
        $createdAt = new DateTimeImmutable('2026-01-01 10:00:00');
        $updatedAt = new DateTimeImmutable('2026-01-01 10:00:00');

        $relationship = new Relationship(
            id: 1,
            personId: 1,
            relativeId: 2,
            type: RelationshipType::PARENT,
            metadata: null,
            createdAt: $createdAt,
            updatedAt: $updatedAt
        );

        $this->repository->save($relationship);

        // Удаляем Relationship
        $this->repository->delete(1);

        // Проверяем, что Relationship удален
        $deletedRelationship = $this->repository->findById(1);

        self::assertNull($deletedRelationship);
    }
}
