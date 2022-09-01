<?php

namespace Abd\User\Providers;

use Abd\User\Database\Seeders\UserTableSeeder;
use Abd\User\Models\User;
use Abd\User\Policies\UserPolicy;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class UserServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->loadRoutesFrom(__DIR__.'/../Routes/user_routes.php');
        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations');
        $this->loadFactoriesFrom(__DIR__.'/../Database/Factories');
        $this->loadViewsFrom(__DIR__.'/../Resources/Views', 'User');
        $this->loadJsonTranslationsFrom(__DIR__.'/../Resources/Lang');
        config()->set('auth.providers.users.model', User::class);
        Gate::policy(User::class, UserPolicy::class);
        DatabaseSeeder::$seeders[] = UserTableSeeder::class;
    }
    public function boot()
    {
        $this->app->booted(function () {
            config()->set('sidebar.items.users', [
                "icon" => "i-users",
                "title" => "کاربران",
                "url" => route('users.index'),
            ]);
        });
    }
}
