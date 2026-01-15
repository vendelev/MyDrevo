<?php

declare(strict_types=1);

namespace App\Auth\Presentation\Http\Controller;

use App\Auth\Domain\Request\RegisterRequest;
use App\Auth\Application\UseCase\RegisterUser;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Validator;

final readonly class RegisterController
{
    public function __construct(
        private RegisterUser $registerUser,
    ) {
    }

    public function showRegistrationForm(): \Illuminate\Contracts\View\View
    {
        return View::make('auth.register');
    }

    public function register(Request $request): RedirectResponse
    {
        // Валидация входных данных и создание DTO
        $validator = Validator::make($request->all(), [
            'login' => 'required|string|max:45',
            'email' => 'required|string|email|max:100|unique:gen_user',
            'password' => 'required|string|min:8',
            'first_name' => 'required|string|max:45',
            'middle_name' => 'nullable|string|max:45',
            'last_name' => 'required|string|max:45',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $registerRequest = new RegisterRequest(
            login: $request->input('login'),
            password: $request->input('password'),
            firstName: $request->input('first_name'),
            middleName: $request->input('middle_name'),
            lastName: $request->input('last_name'),
            email: $request->input('email')
        );

        try {
            // Вызов UseCase
            $user = $this->registerUser->handle($registerRequest);

            // Автоматический вход после регистрации
            Auth::login($user);

            return redirect()->route('dashboard');
        } catch (\Throwable) {
            return redirect()->back()->with('error', 'Registration failed')->withInput();
        }
    }
}
