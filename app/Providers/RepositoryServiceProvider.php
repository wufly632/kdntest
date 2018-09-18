<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(\App\Repositories\Good\GoodRepository::class, \App\Repositories\Good\GoodRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\CateAttr\CategoryRepository::class, \App\Repositories\CateAttr\CategoryRepositoryEloquent::class);
        //:end-bindings:
    }
}
