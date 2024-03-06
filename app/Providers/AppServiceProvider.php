<?php

namespace App\Providers;

use App\Services\Mail\ConfirmationService;
use App\Services\Mail\InviteService;
use App\Services\ProjectService;
use App\Services\TaskService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        app()->singleton(InviteService::class, function($app) {
            return new InviteService();
        });
        app()->singleton(ProjectService::class, function($app) {
            return new ProjectService(app(InviteService::class));
        });
        app()->singleton(TaskService::class, function($app) {
            return new TaskService();
        });
        app()->singleton(ConfirmationService::class, function($app) {
            return new ConfirmationService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
