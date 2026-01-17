<?php

declare(strict_types=1);

namespace App\Modules\Family\Infrastructure\Repository;

use App\Modules\Family\Domain\Entity\Relationship;
use App\Modules\Family\Domain\RelationshipRepositoryInterface;
use App\Modules\Family\Infrastructure\Model\Relationship as RelationshipModel;
use App\Modules\Family\Domain\ValueObject\RelationshipType;
use DateTimeImmutable;

class EloquentRelationshipRepository implements RelationshipRepositoryInterface
{
    /**
     * @throws \TypeError
     * @throws \ValueError
     * @throws \DateMalformedStringException
     */
    public function save(Relationship $relationship): void
    {
        $model = RelationshipModel::find($relationship->getId());
        
        if (!$model) {
            $model = new RelationshipModel();
            $model->id = $relationship->getId();
            $model->person_id = $relationship->getPersonId();
            $model->relative_id = $relationship->getRelativeId();
            $model->created_at = $relationship->getCreatedAt()->format('Y-m-d H:i:s');
        }
        
        $model->type = $relationship->getType()->value;
        $model->metadata = $relationship->getMetadata() ?? null;
        $model->updated_at = $relationship->getUpdatedAt()->format('Y-m-d H:i:s');
        
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