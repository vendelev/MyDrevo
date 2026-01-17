<?php

declare(strict_types=1);

namespace App\Family\Infrastructure\Repository;

use App\Family\Domain\Entity\Relationship;
use App\Family\Domain\RelationshipRepositoryInterface;
use App\Family\Infrastructure\Model\Relationship as RelationshipModel;
use App\Family\Domain\ValueObject\RelationshipType;
use DateTimeImmutable;

final class EloquentRelationshipRepository implements RelationshipRepositoryInterface
{
    /**
     * @throws \TypeError
     * @throws \ValueError
     * @throws \DateMalformedStringException
     */
    public function save(Relationship $relationship): void
    {
        $model = RelationshipModel::find($relationship->id);

        if (!$model) {
            $model = new RelationshipModel();
            $model->id = $relationship->id;
            $model->person_id = $relationship->personId;
            $model->relative_id = $relationship->relativeId;
            $model->created_at = $relationship->createdAt->format('Y-m-d H:i:s');
        }

        $model->type = $relationship->type->value;
        $model->metadata = $relationship->metadata ?? null;
        $model->updated_at = $relationship->updatedAt->format('Y-m-d H:i:s');

        $model->save();
    }

    /**
     * @throws \TypeError
     * @throws \ValueError
     * @throws \DateMalformedStringException
     */
    public function findById(int $id): ?Relationship
    {
        $model = RelationshipModel::find($id);

        if (!$model) {
            return null;
        }

        return $this->mapToEntity($model);
    }

    /**
     * @return list<Relationship>
     * @throws \TypeError
     * @throws \ValueError
     * @throws \DateMalformedStringException
     */
    public function findByPersonId(int $personId): array
    {
        $models = RelationshipModel::where('person_id', $personId)->get();

        $result = [];
        foreach ($models as $model) {
            $result[] = $this->mapToEntity($model);
        }

        return $result;
    }

    public function delete(int $id): void
    {
        RelationshipModel::where('id', $id)->delete();
    }

    /**
     * @throws \TypeError
     * @throws \ValueError
     * @throws \DateMalformedStringException
     */
    private function mapToEntity(RelationshipModel $model): Relationship
    {
        $type = RelationshipType::from($model->type);

        return new Relationship(
            (int) $model->id,
            (int) $model->person_id,
            (int) $model->relative_id,
            $type,
            $model->metadata,
            new DateTimeImmutable($model->created_at),
            new DateTimeImmutable($model->updated_at)
        );
    }
}
