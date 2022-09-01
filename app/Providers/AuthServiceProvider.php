<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('access-admin', function (User $user) {
            return $user->role->role === 'admin'
                        ? Response::allow()
                        : Response::deny('Tu dois etre admin');
        });

        Gate::define('access-tenant', function (User $user) {
            return $user->role->role === 'tenant'
                        ? Response::allow()
                        : Response::deny('Tu dois etre tenant');
        });

        Gate::define('access-client', function (User $user) {
            return $user->role->role === 'client'
                        ? Response::allow()
                        : Response::deny('Tu dois etre client');
        });
    }
}
