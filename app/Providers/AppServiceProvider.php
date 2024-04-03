<?php

namespace App\Providers;

use App\Repositories\Contracts\PlayerRepositoryContract;
use App\Repositories\PlayerRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(PlayerRepositoryContract::class, PlayerRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
