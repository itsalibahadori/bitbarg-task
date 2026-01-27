<?php

namespace App\Providers;

use App\Models\Task;
use App\Models\User;
use App\Observers\V1\TaskObserver;
use App\Observers\V1\UserObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Task::observe(TaskObserver::class);
        User::observe(UserObserver::class);
    }
}
