<?php

namespace App\Providers;

use App\Repositories\UserInterface;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class RegisterServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->app->bind(
            UserInterface::class,
            UserRepository::class
        );
    }
}
