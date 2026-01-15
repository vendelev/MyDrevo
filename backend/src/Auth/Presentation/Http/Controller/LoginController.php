<?php

declare(strict_types=1);

namespace App\Auth\Presentation\Http\Controller;

use App\Auth\Application\UseCase\LoginUser;
use App\Auth\Domain\Request\LoginRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View as ViewFacade;

final readonly class LoginController
{
    public function __construct(
        private LoginUser $loginUser,
    ) {
    }

    public function showLoginForm(): View
    {
        return ViewFacade::make('auth::login');
    }

    public function login(Request $request): RedirectResponse
    {
        // Валидация входных данных и создание DTO
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:100',
            'password' => 'required|string|min:8',
            'remember' => 'boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $loginRequest = new LoginRequest(
            email: $request->input('email'),
            password: $request->input('password'),
            remember: $request->has('remember')
        );

        try {
            // Вызов UseCase
            $this->loginUser->handle($loginRequest);

            // Редирект на dashboard
            return redirect()->route('dashboard');
        } catch (\Throwable) {
            return redirect()->back()->with('error', 'Invalid credentials')->withInput();
        }
    }
}
