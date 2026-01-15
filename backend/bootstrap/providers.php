<?php

declare(strict_types=1);

use App\Auth\Presentation\Config\AuthServiceProvider;
use App\Core\Presentation\Config\RouteServiceProvider;
use Illuminate\Auth\AuthServiceProvider as IlluminateAuthServiceProvider;
use Illuminate\Cookie\CookieServiceProvider;

return [
    RouteServiceProvider::class,
    AuthServiceProvider::class,
    IlluminateAuthServiceProvider::class,
    CookieServiceProvider::class,
];
