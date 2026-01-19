<?php

declare(strict_types=1);

namespace App\Auth\Application\Command;

use App\Auth\Domain\Entity\User;
use Illuminate\Support\Facades\DB;

final readonly class RegisterUserCommand
{
    public function handle(User $user): void
    {
        DB::table('gen_user')->updateOrInsert(
            ['id' => $user->getId()],
            [
                'login' => $user->getLogin(),
                'password' => $user->getAuthPassword(),
                'fname' => $user->getFname(),
                'sname' => $user->getSname(),
                'surname' => $user->getSurname(),
                'email' => $user->getEmail(),
                'user_type' => $user->getUserType(),
                'active' => $user->isActive() ? 1 : 0,
                'create_date' => $user->getCreateDate(),
            ]
        );
    }
}
