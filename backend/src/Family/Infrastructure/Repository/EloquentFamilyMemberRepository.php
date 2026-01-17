<?php

declare(strict_types=1);

namespace App\Modules\Family\Infrastructure\Repository;

use App\Modules\Family\Domain\Entity\FamilyMember;
use App\Modules\Family\Domain\FamilyMemberRepositoryInterface;
use App\Modules\Family\Infrastructure\Model\FamilyMember as FamilyMemberModel;
use App\Modules\Family\Domain\ValueObject\FullName;
use App\Modules\Family\Domain\ValueObject\Gender;
use App\Modules\Family\Domain\ValueObject\LifePeriod;
use DateTimeImmutable;

class EloquentFamilyMemberRepository implements FamilyMemberRepositoryInterface
{
    /**
     * @throws \DateMalformedStringException
     * @throws \TypeError
     * @throws \ValueError
     */
    public function save(FamilyMember $familyMember): void
    {
        $model = FamilyMemberModel::find($familyMember->getId());
        
        if (!$model) {
            $model = new FamilyMemberModel();
            $model->id = $familyMember->getId();
            $model->user_id = $familyMember->getUserId();
            $model->created_at = $familyMember->getCreatedAt()->format('Y-m-d H:i:s');
        }
        
        $fullName = $familyMember->getFullName();
        $lifePeriod = $familyMember->getLifePeriod();
        
        $model->first_name = $fullName->getFirstName();
        $model->last_name = $fullName->getLastName();
        $model->middle_name = $fullName->getMiddleName();
        $model->gender = $familyMember->getGender()->value;
        $model->birth_date = $lifePeriod->getBirthDate()?->format('Y-m-d');
        $model->death_date = $lifePeriod->getDeathDate()?->format('Y-m-d');
        $model->biography = $familyMember->getBiography();
        $model->updated_at = $familyMember->getUpdatedAt()->format('Y-m-d H:i:s');
        
        $model->save();
    }

    /**
     * @throws \DateMalformedStringException
     * @throws \TypeError
     * @throws \ValueError
     * @throws \App\Modules\Family\Domain\Exception\InvalidLifePeriodException
     */
    public function findById(int $id): ?FamilyMember
    {
        $model = FamilyMemberModel::find($id);
        
        if (!$model) {
            return null;
        }
        
        return $this->mapToEntity($model);
    }

    /**
     * @throws \DateMalformedStringException
     * @throws \TypeError
     * @throws \ValueError
     * @throws \App\Modules\Family\Domain\Exception\InvalidLifePeriodException
     */
    public function findByUserId(int $userId): ?FamilyMember
    {
        $model = FamilyMemberModel::where('user_id', $userId)->first();
        
        if (!$model) {
            return null;
        }
        
        return $this->mapToEntity($model);
    }

    public function delete(int $id): void
    {
        FamilyMemberModel::where('id', $id)->delete();
    }
    
    /**
     * @throws \DateMalformedStringException
     * @throws \TypeError
     * @throws \ValueError
     * @throws \App\Modules\Family\Domain\Exception\InvalidLifePeriodException
     */
    private function mapToEntity(FamilyMemberModel $model): FamilyMember
    {
        $fullName = new FullName(
            $model->first_name,
            $model->last_name,
            $model->middle_name
        );
        
        $birthDate = $model->birth_date ? new DateTimeImmutable($model->birth_date) : null;
        $deathDate = $model->death_date ? new DateTimeImmutable($model->death_date) : null;
        $lifePeriod = new LifePeriod($birthDate, $deathDate);
        
        $gender = Gender::from($model->gender);
        
        return new FamilyMember(
            (int) $model->id,
            $fullName,
            $gender,
            $lifePeriod,
            $model->biography,
            (int) $model->user_id,
            new DateTimeImmutable($model->created_at),
            new DateTimeImmutable($model->updated_at)
        );
    }
}