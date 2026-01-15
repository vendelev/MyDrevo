<?php

declare(strict_types=1);

namespace App\Auth\Application\Query;

use App\Auth\Domain\Entity\User;
use Illuminate\Support\Facades\DB;

final readonly class GetUserByEmailQuery
{
    /**
     * @throws \DateMalformedStringException
     */
    public function handle(string $email): ?User
    {
        $userData = DB::table('gen_user')->where('email', $email)->first();

        if (!$userData) {
            return null;
        }

        $userData = (array) $userData;

        return new User(
            $userData['id'],
            $userData['login'],
            $userData['password'],
            $userData['fname'],
            $userData['sname'] ?? null,
            $userData['surname'],
            $userData['email'],
            $userData['user_type'],
            (bool) $userData['active'],
            new \DateTimeImmutable($userData['create_date'])
        );
    }
}
