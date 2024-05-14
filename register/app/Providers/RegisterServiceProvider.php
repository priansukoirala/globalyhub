<?php

namespace App\Providers;

use App\Repositories\ClientInterface;
use App\Repositories\ClientRepository;
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
            ClientInterface::class,
            ClientRepository::class
        );
    }
}
