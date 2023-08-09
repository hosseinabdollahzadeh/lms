<?php

namespace Abd\User\Providers;

use Abd\RolePermissions\Models\Permission;
use Abd\User\Database\Seeders\UserTableSeeder;
use Abd\User\Models\User;
use Abd\User\Policies\UserPolicy;
use Abd\User\Http\Middleware\StoreUserIp;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class UserServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->loadRoutesFrom(__DIR__ . '/../Routes/user_routes.php');
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        $this->loadFactoriesFrom(__DIR__ . '/../Database/Factories');
        $this->loadViewsFrom(__DIR__ . '/../Resources/Views', 'User');
        $this->loadJsonTranslationsFrom(__DIR__ . '/../Resources/Lang');

        Factory::guessFactoryNamesUsing(function (string $modelName) {
            return 'Abd\User\Database\Factories\\' . class_basename($modelName) . 'Factory';
        });

        config()->set('auth.providers.users.model', User::class);
        Gate::policy(User::class, UserPolicy::class);
        DatabaseSeeder::$seeders[] = UserTableSeeder::class;
    }

    public function boot(Router $router)
    {
        $router->pushMiddlewareToGroup('web', StoreUserIp::class);
        $this->app->booted(function () {
            config()->set('sidebar.items.users', [
                "icon" => "i-users",
                "title" => "کاربران",
                "url" => route('users.index'),
                "permission" => Permission::PERMISSION_MANAGE_USERS
            ]);
            config()->set('sidebar.items.usersInformation', [
                "icon" => "i-user__information",
                "title" => "اطلاعات کاربری",
                "url" => route('users.editProfile'),
            ]);
        });
    }
}
