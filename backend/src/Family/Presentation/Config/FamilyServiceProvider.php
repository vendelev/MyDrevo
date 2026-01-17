<?php

declare(strict_types=1);

namespace App\Family\Presentation\Config;

use App\Family\Application\Query\GetFamilyMemberQuery;
use App\Family\Application\Query\ListFamilyMembersQuery;
use App\Family\Application\UseCase\CreateFamilyMember;
use App\Family\Application\UseCase\DeleteFamilyMember;
use App\Family\Application\UseCase\GetFamilyMember;
use App\Family\Application\UseCase\ListFamilyMembers;
use App\Family\Application\UseCase\UpdateFamilyMember;
use App\Family\Domain\FamilyMemberRepositoryInterface;
use App\Family\Infrastructure\Repository\EloquentFamilyMemberRepository;
use Illuminate\Support\ServiceProvider;

final class FamilyServiceProvider extends ServiceProvider
{
    #[\Override]
    public function register(): void
    {
        $this->app->bind(FamilyMemberRepositoryInterface::class, EloquentFamilyMemberRepository::class);

        $this->app->singleton(CreateFamilyMember::class);
        $this->app->singleton(UpdateFamilyMember::class);
        $this->app->singleton(DeleteFamilyMember::class);
        $this->app->singleton(GetFamilyMember::class);
        $this->app->singleton(ListFamilyMembers::class);

        $this->app->singleton(GetFamilyMemberQuery::class);
        $this->app->singleton(ListFamilyMembersQuery::class);
    }
}
