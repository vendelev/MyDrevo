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
                'fname' => $user->getFirstName(),
                'sname' => $user->getMiddleName(),
                'surname' => $user->getLastName(),
                'email' => $user->getEmail(),
                'user_type' => $user->getUserType(),
                'active' => $user->isActive() ? 1 : 0,
                'create_date' => $user->getCreatedAt()->format('Y-m-d H:i:s'),
            ]
        );
    }
}
