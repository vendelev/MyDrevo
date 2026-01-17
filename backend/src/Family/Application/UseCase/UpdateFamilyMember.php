<?php

declare(strict_types=1);

namespace App\Family\Application\UseCase;

use App\Family\Application\Command\UpdateFamilyMemberCommand;
use App\Family\Domain\Entity\FamilyMember;
use App\Family\Domain\FamilyMemberRepositoryInterface;
use App\Family\Domain\ValueObject\FullName;
use App\Family\Domain\ValueObject\Gender;
use App\Family\Domain\ValueObject\LifePeriod;
use DateTimeImmutable;

final readonly class UpdateFamilyMember
{
    public function __construct(
        private FamilyMemberRepositoryInterface $familyMemberRepository,
    ) {
    }

    /**
     * @throws \DateMalformedStringException
     * @throws \App\Family\Domain\Exception\InvalidLifePeriodException
     * @throws \RuntimeException
     * @throws \TypeError
     * @throws \ValueError
     */
    public function handle(UpdateFamilyMemberCommand $command): FamilyMember
    {
        $familyMember = $this->familyMemberRepository->findById($command->id);

        if (!$familyMember instanceof \App\Family\Domain\Entity\FamilyMember) {
            throw new \RuntimeException('Family member not found');
        }

        $fullName = new FullName(
            $command->firstName,
            $command->lastName,
            $command->middleName
        );

        $birthDate = $command->birthDate ? new DateTimeImmutable($command->birthDate) : null;
        $deathDate = $command->deathDate ? new DateTimeImmutable($command->deathDate) : null;
        $lifePeriod = new LifePeriod($birthDate, $deathDate);

        $gender = Gender::from($command->gender);

        // Create new instance with updated values
        $updatedFamilyMember = new FamilyMember(
            id: $familyMember->id,
            fullName: $fullName,
            gender: $gender,
            lifePeriod: $lifePeriod,
            birthPlace: $command->birthPlace,
            deathPlace: $command->deathPlace,
            biography: $command->biography,
            userId: $familyMember->userId,
            createdAt: $familyMember->createdAt,
            updatedAt: new DateTimeImmutable()
        );

        $this->familyMemberRepository->save($updatedFamilyMember);

        return $updatedFamilyMember;
    }
}
