<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\ValidatePostSize::class,
            \App\Http\Middleware\DisableIfHttps::class,
            \Barryvdh\DomPDF\Middleware\Middleware::class,
            \App\Http\Middleware\SubstituteBindings::class,
            \App\Http\Middleware\TraceRequestMiddleware::class,
        ],

        'api' => [
            'throttle:api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            \App\Http\Middleware\TraceRequestMiddleware::class,
        ],
    ];

    /**
     * The application's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'auth.basic' => \AuthenticateBasic::class,
        'cache.headers' => \Illuminate\Routing\Middleware\SetHttpCacheHeaders::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\EnsureGuest::class,
        'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'trace' => \App\Http\Middleware\TraceRequestMiddleware::class,
    ];
}