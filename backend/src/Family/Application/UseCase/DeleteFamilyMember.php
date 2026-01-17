<?php

declare(strict_types=1);

namespace App\Family\Application\UseCase;

use App\Family\Application\Command\DeleteFamilyMemberCommand;
use App\Family\Domain\FamilyMemberRepositoryInterface;

final readonly class DeleteFamilyMember
{
    public function __construct(
        private FamilyMemberRepositoryInterface $familyMemberRepository,
    ) {
    }

    /**
     * @throws \RuntimeException
     */
    public function handle(DeleteFamilyMemberCommand $command): void
    {
        $familyMember = $this->familyMemberRepository->findById($command->id);

        if (!$familyMember instanceof \App\Family\Domain\Entity\FamilyMember) {
            throw new \RuntimeException('Family member not found');
        }

        $this->familyMemberRepository->delete($command->id);
    }
}
