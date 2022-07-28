<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Repositories\Car\CarRepositoryContract', 'App\Repositories\Car\EloquentCarRepository');
        $this->app->bind('App\Repositories\User\UserRepositoryContract', 'App\Repositories\User\EloquentUserRepository');
    }
}
