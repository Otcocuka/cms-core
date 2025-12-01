<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
        then: function () {
            // Загружаем модульные роуты
            $modules = ['Content', 'Forms', 'Media', 'SEO', 'Settings'];

            foreach ($modules as $module) {
                $webRoutes = base_path("Modules/{$module}/routes/web.php");
                $apiRoutes = base_path("Modules/{$module}/routes/api.php");

                if (file_exists($webRoutes)) {
                    Route::middleware('web')
                        ->group($webRoutes);
                }

                if (file_exists($apiRoutes)) {
                    Route::middleware('api')
                        ->prefix('api')
                        ->group($apiRoutes);
                }
            }
        },
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Настройка middleware группы 'web'
        $middleware->web(append: [
            \Illuminate\Cookie\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ]);

        // Регистрируем алиасы middleware
        $middleware->alias([
            'auth' => \Illuminate\Auth\Middleware\Authenticate::class,
            'guest' => \Illuminate\Auth\Middleware\RedirectIfAuthenticated::class,
            'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
