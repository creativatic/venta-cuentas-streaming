<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\Account;
use App\Models\Client;
use App\Models\Company;
use App\Models\Permission;
use App\Models\Role;
use App\Models\Service;
use App\Models\User;
use App\Policies\AccountPolicy;
use App\Policies\ClientPolicy;
use App\Policies\CompanyPolicy;
use App\Policies\MovementPolicy;
use App\Policies\PermissionPolicy;
use App\Policies\RolePolicy;
use App\Policies\ServicePolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
        User::class => UserPolicy::class,
        Role::class => RolePolicy::class,
        Permission::class => PermissionPolicy::class,
        Company::class => CompanyPolicy::class,
        //Movement::class => MovementPolicy::class,
        Account::class => AccountPolicy::class,
        Client::class => ClientPolicy::class,
        Service::class => ServicePolicy::class, // Si aplica
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // Registrar Gates para los permisos
        $this->registerPermissions();
        
        // Registrar middleware
        $this->app['router']->aliasMiddleware('role', \App\Http\Middleware\CheckRole::class);
    }
    protected function registerPermissions()
    {
        Gate::before(function ($user, $ability) {
            if ($user->hasRole('Super Admin')) {
                return true;
            }
        });

        foreach (Permission::all() as $permission) {
            Gate::define($permission->title, function ($user) use ($permission) {
                return $user->hasPermission($permission->title);
            });
        }
    }
}
