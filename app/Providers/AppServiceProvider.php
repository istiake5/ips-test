<?php

namespace App\Providers;

use App\Repositories\AchievementsRepositoryInterface;
use App\Repositories\EloquentAchievementsRepository;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(AchievementsRepositoryInterface::class, EloquentAchievementsRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
