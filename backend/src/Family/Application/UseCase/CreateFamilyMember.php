<?php

declare(strict_types=1);

namespace App\Family\Application\UseCase;

use App\Family\Application\Command\CreateFamilyMemberCommand;
use App\Family\Domain\Entity\FamilyMember;
use App\Family\Domain\FamilyMemberRepositoryInterface;
use App\Family\Domain\ValueObject\FullName;
use App\Family\Domain\ValueObject\Gender;
use App\Family\Domain\ValueObject\LifePeriod;
use DateTimeImmutable;

final readonly class CreateFamilyMember
{
    public function __construct(
        private FamilyMemberRepositoryInterface $familyMemberRepository,
    ) {
    }

    /**
     * @throws \DateMalformedStringException
     * @throws \App\Family\Domain\Exception\InvalidLifePeriodException
     * @throws \TypeError
     * @throws \ValueError
     */
    public function handle(CreateFamilyMemberCommand $command): FamilyMember
    {
        $fullName = new FullName(
            $command->firstName,
            $command->lastName,
            $command->middleName
        );

        $birthDate = $command->birthDate ? new DateTimeImmutable($command->birthDate) : null;
        $deathDate = $command->deathDate ? new DateTimeImmutable($command->deathDate) : null;
        $lifePeriod = new LifePeriod($birthDate, $deathDate);

        $gender = Gender::from($command->gender);

        $familyMember = new FamilyMember(
            id: 0, // Will be set by DB
            fullName: $fullName,
            gender: $gender,
            lifePeriod: $lifePeriod,
            birthPlace: $command->birthPlace,
            deathPlace: $command->deathPlace,
            biography: $command->biography,
            userId: $command->userId,
            createdAt: new DateTimeImmutable(),
            updatedAt: new DateTimeImmutable()
        );

        $this->familyMemberRepository->save($familyMember);

        return $familyMember;
    }
}
