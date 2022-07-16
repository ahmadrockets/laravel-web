<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

// interfaces
use App\Repositories\UserRepositoryInterface;

// repository
use App\Repositories\Mysql\UserRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
