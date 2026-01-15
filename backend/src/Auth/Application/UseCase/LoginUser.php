<?php

declare(strict_types=1);

namespace App\Auth\Application\UseCase;

use App\Auth\Application\Query\GetUserByEmailQuery;
use App\Auth\Domain\Entity\User;
use App\Auth\Domain\Request\LoginRequest;
use Illuminate\Support\Facades\Hash;

final readonly class LoginUser
{
    public function __construct(
        private GetUserByEmailQuery $getUserByEmailQuery,
    ) {
    }

    /**
     * @throws \DateMalformedStringException
     */
    public function handle(LoginRequest $request): User
    {
        // Поиск пользователя по email
        $user = $this->getUserByEmailQuery->handle($request->email);

        // Проверка существования пользователя и пароля
        if (!$user instanceof User || !Hash::check($request->password, $user->getAuthPassword())) {
            throw new \RuntimeException('Invalid credentials');
        }

        return $user;
    }
}
