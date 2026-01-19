<?php

declare(strict_types=1);

namespace App\Auth\Application\UseCase;

use App\Auth\Application\Command\RegisterUserCommand;
use App\Auth\Application\Query\GetUserByEmailQuery;
use App\Auth\Domain\Entity\User;
use App\Auth\Domain\Request\RegisterRequest;
use Illuminate\Support\Facades\Hash;

final readonly class RegisterUser
{
    public function __construct(
        private RegisterUserCommand $registerUserCommand,
        private GetUserByEmailQuery $getUserByEmailQuery,
    ) {
    }

    /**
     * @throws \DateMalformedStringException
     */
    public function handle(RegisterRequest $request): User
    {
        // Проверка уникальности email
        if ($this->getUserByEmailQuery->handle($request->email) instanceof User) {
            throw new \RuntimeException('Email already exists');
        }

        // Создание пользователя
        $user = new User([
            'id' => 0, // ID будет назначен БД
            'login' => $request->login,
            'password' => Hash::make($request->password),
            'firstName' => $request->firstName,
            'middleName' => $request->middleName,
            'lastName' => $request->lastName,
            'email' => $request->email,
            'userType' => 1, // По умолчанию обычный пользователь
            'active' => true,
            'createdAt' => 'now',
        ]);

        // Сохранение пользователя
        $this->registerUserCommand->handle($user);

        return $user;
    }
}
