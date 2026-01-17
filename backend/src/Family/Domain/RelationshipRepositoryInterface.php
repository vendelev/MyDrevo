<?php

declare(strict_types=1);

namespace App\Modules\Family\Domain;

use App\Modules\Family\Domain\Entity\Relationship;

interface RelationshipRepositoryInterface
{
    public function save(Relationship $relationship): void;

    public function findById(int $id): ?Relationship;

    /** @return list<Relationship> */
    public function findByPersonId(int $personId): array;

    public function delete(int $id): void;
}