<?php

declare(strict_types=1);

use App\Auth\Presentation\Config\AuthServiceProvider;
use App\Core\Presentation\Config\CoreServiceProvider;
use App\Core\Presentation\Config\RouteServiceProvider;
use App\Example\Presentation\Config\ExampleServiceProvider;
use Illuminate\Auth\AuthServiceProvider as IlluminateAuthServiceProvider;
use Illuminate\Cookie\CookieServiceProvider;

return [
    CoreServiceProvider::class,
    ExampleServiceProvider::class,
    RouteServiceProvider::class,
    AuthServiceProvider::class,
    IlluminateAuthServiceProvider::class,
    CookieServiceProvider::class,
];
