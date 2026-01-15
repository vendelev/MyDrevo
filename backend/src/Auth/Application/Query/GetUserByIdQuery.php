<?php

declare(strict_types=1);

namespace App\Auth\Application\Query;

use App\Auth\Domain\Entity\User;
use Illuminate\Support\Facades\DB;

final readonly class GetUserByIdQuery
{
    /**
     * @throws \DateMalformedStringException
     */
    public function handle(int $id): ?User
    {
        $userData = DB::table('gen_user')->find($id);

        if (!$userData) {
            return null;
        }

        $userData = (array) $userData;

        return new User(
            $userData['id'],
            $userData['login'],
            $userData['password'],
            $userData['fname'],
            $userData['sname'],
            $userData['surname'],
            $userData['email'],
            $userData['user_type'],
            (bool) $userData['active'],
            new \DateTimeImmutable($userData['create_date'])
        );
    }
}
