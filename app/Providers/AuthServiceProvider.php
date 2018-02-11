<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\User;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */

    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
        //指定授权策略 这里制订了User的授权策略为UserPolicy
        \App\Models\User::class=>\App\Policies\Userpolicy::class,
        \App\Models\Status::class=>\App\Policies\StatusPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
