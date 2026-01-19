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

        return new User([
            'id' => $userData['id'],
            'login' => $userData['login'],
            'password' => $userData['password'],
            'firstName' => $userData['fname'],
            'middleName' => $userData['sname'] ?? null,
            'lastName' => $userData['surname'],
            'email' => $userData['email'],
            'userType' => $userData['user_type'],
            'active' => (bool) $userData['active'],
            'createdAt' => new \DateTimeImmutable($userData['create_date'])->format('Y-m-d H:i:s'),
        ]);
    }
}
