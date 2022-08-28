<?php

namespace Abd\RolePermissions\Providers;

use Abd\RolePermissions\Database\Seeders\RolePermissionTableSeeder;
use Database\Seeders\DatabaseSeeder;
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
