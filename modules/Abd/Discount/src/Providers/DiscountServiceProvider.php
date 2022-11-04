<?php

namespace Abd\Discount\Providers;

use Abd\RolePermissions\Models\Permission;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class DiscountServiceProvider extends ServiceProvider
{
    public $namespace = "Abd\Discount\Http\Controllers";
    public function register()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(__DIR__ . '/../Routes/discounts_routes.php');
        $this->loadViewsFrom(__DIR__.'/../Resources/Views', 'Discounts');
        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations');
    }

    public function boot()
    {
        $this->app->booted(function () {
            config()->set('sidebar.items.discounts', [
                "icon" => "i-discounts",
                "title" => "تخفیف ها",
                "url" => route('discounts.index'),
                "permission" => Permission::PERMISSION_MANAGE_DISCOUNTS,
            ]);
        });
    }
}
