<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(\App\Repositories\UsersRepository::class, \App\Repositories\UsersRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\CreateDoctorsTableRepository::class, \App\Repositories\CreateDoctorsTableRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\CreateWechatUsersTableRepository::class, \App\Repositories\CreateWechatUsersTableRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\CreateDoctorPatientsTableRepository::class, \App\Repositories\CreateDoctorPatientsTableRepositoryEloquent::class);
        //:end-bindings:
    }
}
