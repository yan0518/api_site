<?php

namespace App\Providers;

use App\Helper\EnvHelper;
use Carbon\Carbon;
use Laravel\Passport\Passport;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;


class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        if(!EnvHelper::isLocalEnv()){
            Passport::tokensExpireIn(Carbon::now()->addMinutes(30));
            Passport::refreshTokensExpireIn(Carbon::now()->addDays(180));
        }
        Passport::routes();
    }
}
