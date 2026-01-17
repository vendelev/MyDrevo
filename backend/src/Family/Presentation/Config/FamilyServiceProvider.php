<?php

declare(strict_types=1);

namespace App\Family\Presentation\Config;

use App\Family\Domain\FamilyMemberRepositoryInterface;
use App\Family\Infrastructure\Repository\EloquentFamilyMemberRepository;
use Illuminate\Support\ServiceProvider;

final class FamilyServiceProvider extends ServiceProvider
{
    #[\Override]
    public function register(): void
    {
        $this->app->bind(FamilyMemberRepositoryInterface::class, EloquentFamilyMemberRepository::class);
    }
}
