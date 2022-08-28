<?php

namespace Abd\RolePermissions\Providers;

use Abd\RolePermissions\Database\Seeders\RolePermissionTableSeeder;
use Abd\RolePermissions\Models\Permission;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class RolePermissionsServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations');
        $this->loadViewsFrom(__DIR__.'/../Resources/Views', 'RolePermissions');
        $this->loadRoutesFrom(__DIR__.'/../Routes/RolePermissions_routes.php');
        $this->loadJsonTranslationsFrom(__DIR__ .'/../Resources/Lang');
        DatabaseSeeder::$seeders[] = RolePermissionTableSeeder::class;

        Gate::before(function ($user){
            return $user->hasPermissionTo(Permission::PERMISSION_SUPER_ADMIN) ? true : null;
        });
    }
    public function boot()
    {
        $this->app->booted(function () {
            config()->set('sidebar.items.role-permissions', [
                "icon" => "i-role-permissions",
                "title" => "نقش های کاربری",
                "url" => route('role-permissions.index'),
            ]);
        });
    }
}
