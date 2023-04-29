<?php

namespace App\Providers;

use App\Interfaces\HorarioServiceInterface;
use App\Services\HorarioService;
use Illuminate\Support\ServiceProvider;

class HorarioServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(HorarioServiceInterface::class, HorarioService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
