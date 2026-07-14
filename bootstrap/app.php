<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function () {
            Route::middleware('web')->group(base_path('routes/EmployeeRoute.php'));
            Route::middleware('web')->group(base_path('routes/HrManagerRoute.php'));
            Route::middleware('web')->group(base_path('routes/AdminRoute.php'));
            Route::middleware('web')->group(base_path('routes/ProjectManagerRoute.php'));
            Route::middleware('web')->group(base_path('routes/MarketingManagerRoute.php'));
            Route::middleware('web')->group(base_path('routes/SalesManagerRoute.php'));
            Route::middleware('web')->group(base_path('routes/TeamLeaderRoute.php'));
            Route::middleware('web')->group(base_path('routes/AccountManagerRoute.php'));
        }
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'super_admin' => App\Http\Middleware\AdminAuthMiddleware::class,
            'employee' => App\Http\Middleware\EmployeeAuthMiddleware::class,
            'hr_manager'=> App\Http\Middleware\HrManagerMiddleware::class,
            'team_leader'=> App\Http\Middleware\TeamLeaderMiddleware::class,
            'project_manager'=> App\Http\Middleware\ProjectManagerManagerMiddleware::class,
            'sales_manager'=> App\Http\Middleware\SalesManagerMiddleware::class,
            'marketing_manager'=> App\Http\Middleware\MarketingManagerMiddleware::class,
            "account_manager"=> App\Http\Middleware\AccountManagerMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
