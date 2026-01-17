<?php

declare(strict_types=1);

namespace App\Family\Presentation\Http\Controller;

use App\Family\Application\Command\CreateFamilyMemberCommand;
use App\Family\Application\Command\DeleteFamilyMemberCommand;
use App\Family\Application\Command\UpdateFamilyMemberCommand;
use App\Family\Application\Dto\FamilyMemberDto;
use App\Family\Application\UseCase\CreateFamilyMember;
use App\Family\Application\UseCase\DeleteFamilyMember;
use App\Family\Application\UseCase\GetFamilyMember;
use App\Family\Application\UseCase\ListFamilyMembers;
use App\Family\Application\UseCase\UpdateFamilyMember;
use App\Family\Domain\Request\CreateFamilyMemberRequest;
use App\Family\Domain\Request\UpdateFamilyMemberRequest;
use App\Family\Application\Response\FamilyMemberListResponse;
use App\Family\Application\Response\FamilyMemberResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

final readonly class FamilyMemberController
{
    public function __construct(
        private CreateFamilyMember $createFamilyMember,
        private UpdateFamilyMember $updateFamilyMember,
        private DeleteFamilyMember $deleteFamilyMember,
        private GetFamilyMember $getFamilyMember,
        private ListFamilyMembers $listFamilyMembers,
    ) {
    }

    /**
     * @throws \App\Family\Domain\Exception\InvalidLifePeriodException
     * @throws \DateMalformedStringException
     * @throws \TypeError
     * @throws \ValueError
     */
    public function create(Request $request): JsonResponse
    {
        $userId = (int) Auth::id();

        $createRequest = new CreateFamilyMemberRequest(
            firstName: $request->input('first_name'),
            lastName: $request->input('last_name'),
            middleName: $request->input('middle_name'),
            gender: $request->input('gender'),
            birthDate: $request->input('birth_date'),
            birthPlace: $request->input('birth_place'),
            deathDate: $request->input('death_date'),
            deathPlace: $request->input('death_place'),
            biography: $request->input('biography'),
        );

        $command = new CreateFamilyMemberCommand(
            firstName: $createRequest->firstName,
            lastName: $createRequest->lastName,
            middleName: $createRequest->middleName,
            gender: $createRequest->gender,
            birthDate: $createRequest->birthDate,
            birthPlace: $createRequest->birthPlace,
            deathDate: $createRequest->deathDate,
            deathPlace: $createRequest->deathPlace,
            biography: $createRequest->biography,
            userId: $userId,
        );

        $familyMember = $this->createFamilyMember->handle($command);

        $dto = new FamilyMemberDto(
            id: $familyMember->id,
            firstName: $familyMember->fullName->firstName,
            lastName: $familyMember->fullName->lastName,
            middleName: $familyMember->fullName->middleName,
            gender: $familyMember->gender->value,
            birthDate: $familyMember->lifePeriod->birthDate?->format('Y-m-d'),
            birthPlace: $createRequest->birthPlace,
            deathDate: $familyMember->lifePeriod->deathDate?->format('Y-m-d'),
            deathPlace: $createRequest->deathPlace,
            biography: $familyMember->biography,
            userId: $familyMember->userId,
            createdAt: $familyMember->createdAt->format('Y-m-d H:i:s'),
            updatedAt: $familyMember->updatedAt->format('Y-m-d H:i:s'),
        );

        return response()->json(new FamilyMemberResponse($dto), 201);
    }

    /**
     * @throws \App\Family\Domain\Exception\InvalidLifePeriodException
     * @throws \DateMalformedStringException
     * @throws \TypeError
     * @throws \ValueError
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $updateRequest = new UpdateFamilyMemberRequest(
            firstName: $request->input('first_name'),
            lastName: $request->input('last_name'),
            middleName: $request->input('middle_name'),
            gender: $request->input('gender'),
            birthDate: $request->input('birth_date'),
            birthPlace: $request->input('birth_place'),
            deathDate: $request->input('death_date'),
            deathPlace: $request->input('death_place'),
            biography: $request->input('biography'),
        );

        $command = new UpdateFamilyMemberCommand(
            id: $id,
            firstName: $updateRequest->firstName,
            lastName: $updateRequest->lastName,
            middleName: $updateRequest->middleName,
            gender: $updateRequest->gender,
            birthDate: $updateRequest->birthDate,
            birthPlace: $updateRequest->birthPlace,
            deathDate: $updateRequest->deathDate,
            deathPlace: $updateRequest->deathPlace,
            biography: $updateRequest->biography,
        );

        $familyMember = $this->updateFamilyMember->handle($command);

        $dto = new FamilyMemberDto(
            id: $familyMember->id,
            firstName: $familyMember->fullName->firstName,
            lastName: $familyMember->fullName->lastName,
            middleName: $familyMember->fullName->middleName,
            gender: $familyMember->gender->value,
            birthDate: $familyMember->lifePeriod->birthDate?->format('Y-m-d'),
            birthPlace: $updateRequest->birthPlace,
            deathDate: $familyMember->lifePeriod->deathDate?->format('Y-m-d'),
            deathPlace: $updateRequest->deathPlace,
            biography: $familyMember->biography,
            userId: $familyMember->userId,
            createdAt: $familyMember->createdAt->format('Y-m-d H:i:s'),
            updatedAt: $familyMember->updatedAt->format('Y-m-d H:i:s'),
        );

        return response()->json(new FamilyMemberResponse($dto));
    }

    public function delete(int $id): JsonResponse
    {
        $command = new DeleteFamilyMemberCommand($id);

        $this->deleteFamilyMember->handle($command);

        return response()->json(['message' => 'Family member deleted'], 204);
    }

    public function show(int $id): JsonResponse
    {
        $familyMember = $this->getFamilyMember->handle($id);

        if (!$familyMember instanceof \App\Family\Domain\Entity\FamilyMember) {
            return response()->json(['message' => 'Family member not found'], 404);
        }

        $dto = new FamilyMemberDto(
            id: $familyMember->id,
            firstName: $familyMember->fullName->firstName,
            lastName: $familyMember->fullName->lastName,
            middleName: $familyMember->fullName->middleName,
            gender: $familyMember->gender->value,
            birthDate: $familyMember->lifePeriod->birthDate?->format('Y-m-d'),
            birthPlace: $familyMember->birthPlace,
            deathDate: $familyMember->lifePeriod->deathDate?->format('Y-m-d'),
            deathPlace: $familyMember->deathPlace,
            biography: $familyMember->biography,
            userId: $familyMember->userId,
            createdAt: $familyMember->createdAt->format('Y-m-d H:i:s'),
            updatedAt: $familyMember->updatedAt->format('Y-m-d H:i:s'),
        );

        return response()->json(new FamilyMemberResponse($dto));
    }

    public function index(): JsonResponse
    {
        $userId = (int) Auth::id();
        $familyMembers = $this->listFamilyMembers->handle($userId);

        $dtos = [];
        foreach ($familyMembers as $familyMember) {
            $dtos[] = new FamilyMemberDto(
                id: $familyMember->id,
                firstName: $familyMember->fullName->firstName,
                lastName: $familyMember->fullName->lastName,
                middleName: $familyMember->fullName->middleName,
                gender: $familyMember->gender->value,
                birthDate: $familyMember->lifePeriod->birthDate?->format('Y-m-d'),
                birthPlace: $familyMember->birthPlace,
                deathDate: $familyMember->lifePeriod->deathDate?->format('Y-m-d'),
                deathPlace: $familyMember->deathPlace,
                biography: $familyMember->biography,
                userId: $familyMember->userId,
                createdAt: $familyMember->createdAt->format('Y-m-d H:i:s'),
                updatedAt: $familyMember->updatedAt->format('Y-m-d H:i:s'),
            );
        }

        return response()->json(new FamilyMemberListResponse($dtos));
    }
}
