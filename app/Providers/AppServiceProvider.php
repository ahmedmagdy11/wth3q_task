<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider {
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {
        //Register Auth Repository
        $this->app->bind(
            'App\Repositories\Auth\AuthRepositoryInterface',
            'App\Repositories\Auth\AuthRepository'
        );

        //Register Product Repository
        $this->app->bind(
            'App\Repositories\Product\ProductRepositoryInterface',
            'App\Repositories\Product\ProductRepository'
        );

        //Register User Repository
        $this->app->bind(
            'App\Repositories\User\UserRepositoryInterface',
            'App\Repositories\User\UserRepository'
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {
        //
    }
}
