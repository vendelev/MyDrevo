<?php

declare(strict_types=1);

namespace App\Family\Infrastructure\Repository;

use App\Family\Domain\Entity\FamilyMember;
use App\Family\Domain\FamilyMemberRepositoryInterface;
use App\Family\Infrastructure\Model\FamilyMember as FamilyMemberModel;
use App\Family\Domain\ValueObject\FullName;
use App\Family\Domain\ValueObject\Gender;
use App\Family\Domain\ValueObject\LifePeriod;
use DateTimeImmutable;

final class EloquentFamilyMemberRepository implements FamilyMemberRepositoryInterface
{
    /**
     * @throws \DateMalformedStringException
     * @throws \TypeError
     * @throws \ValueError
     */
    public function save(FamilyMember $familyMember): void
    {
        $model = FamilyMemberModel::find($familyMember->id);

        if (!$model) {
            $model = new FamilyMemberModel();
            $model->id = $familyMember->id;
            $model->user_id = $familyMember->userId;
            $model->created_at = $familyMember->createdAt;
        }

        $fullName = $familyMember->fullName;
        $lifePeriod = $familyMember->lifePeriod;

        $model->first_name = $fullName->firstName;
        $model->last_name = $fullName->lastName;
        $model->middle_name = $fullName->middleName;
        $model->gender = $familyMember->gender->value;
        $model->birth_date = $lifePeriod->birthDate;
        $model->death_date = $lifePeriod->deathDate;
        $model->biography = $familyMember->biography;
        $model->updated_at = $familyMember->updatedAt;

        $model->save();
    }

    /**
     * @throws \DateMalformedStringException
     * @throws \TypeError
     * @throws \ValueError
     * @throws \App\Family\Domain\Exception\InvalidLifePeriodException
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
     * @throws \App\Family\Domain\Exception\InvalidLifePeriodException
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
     * @throws \App\Family\Domain\Exception\InvalidLifePeriodException
     */
    private function mapToEntity(FamilyMemberModel $model): FamilyMember
    {
        $fullName = new FullName(
            $model->first_name,
            $model->last_name,
            $model->middle_name
        );

        $birthDate = $model->birth_date instanceof \DateTimeInterface ? new DateTimeImmutable($model->birth_date->format('Y-m-d H:i:s')) : null;
        $deathDate = $model->death_date instanceof \DateTimeInterface ? new DateTimeImmutable($model->death_date->format('Y-m-d H:i:s')) : null;
        $lifePeriod = new LifePeriod($birthDate, $deathDate);

        $gender = Gender::from($model->gender);

        return new FamilyMember(
            (int) $model->id,
            $fullName,
            $gender,
            $lifePeriod,
            $model->biography,
            (int) $model->user_id,
            new DateTimeImmutable($model->created_at->format('Y-m-d H:i:s')),
            new DateTimeImmutable($model->updated_at->format('Y-m-d H:i:s'))
        );
    }
}
