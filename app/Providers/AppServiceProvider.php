<?php

namespace App\Providers;

use App\Repositories\Contracts\DivisionRepositoryContract;
use App\Repositories\Contracts\PlayerRepositoryContract;
use App\Repositories\Contracts\TeamRepositoryContract;
use App\Repositories\DivisionRepository;
use App\Repositories\PlayerRepository;
use App\Repositories\TeamRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(PlayerRepositoryContract::class, PlayerRepository::class);
        $this->app->bind(TeamRepositoryContract::class, TeamRepository::class);
        $this->app->bind(DivisionRepositoryContract::class, DivisionRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
